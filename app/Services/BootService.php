<?php
/**
 * 依赖的启动服务类型。基础的类型，实现增删查改
 * User: Master King
 * Date: 2019/1/11
 */

namespace App\Services;

use App\Contracts\BaseService;
use App\Exceptions\AppException;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;


class BootService implements BaseService
{
    /**
     * 缓存数据
     * @var array
     */
    private static $_cache = [];

    /**
     * 回调的匿名函数。类似于BootService 外挂补丁
     * @var array
     */
    private $closure = null;

    /**
     * 错误异常code
     * @var int
     */
    private $exceptionCode = 10001;

    /**
     * 服务操作的model
     * @var Model
     */
    private $model = null;

    /**
     * 指定一个关联Model
     * @param Model $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * 指定一个异常Code
     * @param int $exceptionCode
     */
    public function setExceptionCode(int $exceptionCode): void
    {
        $this->exceptionCode = $exceptionCode > 0 ? $exceptionCode : $this->exceptionCode;
    }

    /**
     * 设置匿名函数
     * @param  $closure
     */
    public function setClosure($closure): void
    {
        $this->closure = $closure;
    }

    /**
     * Model添加数据
     * @param $data
     * @param int $uid
     * @return array
     * @throws AppException
     */
    public function create($data, int $uid = 0):array
    {
        try {
            $data = array_merge(
                $uid > 0 ? ['uid' => $uid] : [],
                ($data instanceof Request ) ? $data->except('s') : $data
            );
            return array_merge(
                ($result = $this->model::create(
                    array_merge(
                        $data,
                        $this->_before_create($data)
                    )
                )->getAttributes()),
                $this->_after_create($result)
            );
        }catch (Exception $exception) {
            throw new AppException("添加数据错误:".$exception->getMessage(), $this->exceptionCode, $exception);
        }
    }

    /**
     * Model 修改数据
     * @param array $ids
     * @param array $data
     * @return array
     * @throws AppException
     */
    public function update(array $ids, array $data):array
    {
        try {
            $result = [];
            array_walk($ids,function ($id) use($data, &$result){
               $result = array_merge(
                   $result,
                   ['id_'.$id => (
                       $this->model::find($id)->update(
                            array_merge(
                            $data,
                            $this->_before_update([$id], $data)
                            )
                        )?$this->clearCache($id, $data):0
                   )]
               );
               $this->_after_update($id, $data);
            });
            return $result;
        }catch (Exception $exception) {
            throw new AppException("更新错误".$exception->getMessage(), $this->exceptionCode, $exception);
        }
    }

    /**
     * 软删除
     * @param array $ids
     * @return mixed
     * @throws AppException
     */
    public function delete(array $ids)
    {
        try {
            return $this->model::whereIn('id',
                array_merge(
                    $ids,
                    $this->_before_delete($ids)
                )
            )->delete();
        }catch (Exception $exception) {
            throw new AppException("删除失败:".$exception->getMessage(), $this->exceptionCode, $exception);
        }
    }

    /**
     * 恢复数据
     * @param $ids
     * @return mixed
     * @throws Exception
     */
    public function restore($ids){
       try{
           foreach (array_merge($ids, $this->_before_restore($ids)) as $id){
               $this->model::withTrashed()->where('id', $id)->restore();
           }
           return $ids;
       }catch (Exception $exception){
            throw new Exception('恢复失败:'.$exception->getMessage(), $this->exceptionCode, $exception);
       }
    }

    /**
     * 彻底删除。 before_destroy 实现删除前一些递归删除
     * @param array $ids
     * @return mixed
     * @throws AppException
     */
    public function destroy(array $ids): array
    {
        try {
            return $this->_after_destory($this->model::whereIn('id',array_merge(
                $ids,
                $this->_before_destroy($ids)
            ))->forceDelete()?$ids:[]);
        }catch (Exception $exception){
            throw new AppException("删除失败:".$exception->getMessage(), $this->exceptionCode, $exception);
        }
    }

    /**
     * 查询单个数据
     * @param int $id
     * @param array $fields
     * @return array
     * @throws AppException
     */
    public function findById(int $id, array $fields=[]): array
    {
        try {

            return array_merge(
                    ($data = $this->cache($id) ?: $this->model::findOrFail($id)->getAttributes() ),
                    ($data = array_merge($data,[
                        'created' =>
                            isset($data['created'])?
                            is_numeric($data['created'])? Carbon::createFromTimestamp($data['created'])->format('Y-m-d H:i:s'):$data['created']:
                            $data['created_at'],
                        'updated' =>
                            isset($data['updated'])?
                            is_numeric($data['updated'])? Carbon::createFromTimestamp($data['updated'])->format('Y-m-d H:i:s'):$data['updated']:
                            $data['updated_at'],
                    ])),
                    ($data = $this->cache($id, $data)),
                    $this->_after_find($data)
            );
        } catch (\Exception $exception) {
            throw new AppException("查找失败:".$exception->getMessage(),$this->exceptionCode, $exception);
        }
    }

    /**
     * 查询分页数据
     * @param array $condition
     * @param int $limit
     * @param array $order
     * @return array
     * @throws AppException
     */
    public function findAll(array $condition, int $limit, array $order = ['id' => 'desc']): array
    {
        try{
            // 创建
            $model = $this->model::where(
                array_merge($condition, $this->_before_find_all($condition))
            );
            // 条件 where()
            /*foreach ($condition as $where) {
                if (count($where) == 0 ) continue;
                $model->where(...$where);
            }*/
            // 排序
            foreach ($order as $field => $value) {
                $model->orderBy($field, $value);
            }
            return array_merge((
                    $data = $model->paginate($limit)->toArray()
                ), $this->_after_find_all($data));
        } catch (\Exception $exception) {
            throw new AppException("查询数据失败:".$exception->getMessage(),$this->exceptionCode, $exception);
        }
    }

    /**
     * 魔术方法
     * @param $method
     * @param $arguments
     * @return array|mixed
     */
    public function __call($method, $arguments)
    {
        if ( $this->closure != null) {

            if (($closure = array_get($this->closure,$method,false)) === false) return [];
            return call_user_func_array(
                $closure,
                $arguments
            );
        }
        return [];
    }

    /**
     * 自增
     * @param int $id
     * @param string $field
     * @param int $step
     * @return mixed
     * @throws AppException
     */
    public function increment($id, $field, $step)
    {
        try {
            return $this->model::find($id)->increment($field, $step);
        }catch (Exception $exception){
            throw new AppException("递增失败:".$exception->getMessage(), $this->exceptionCode);
        }
    }

    /**
     * 自减
     * @param int $id
     * @param string $field
     * @param int $step
     * @return mixed
     * @throws AppException
     */
    public function decrement($id, $field, $step)
    {
        try {
            return $this->model::find($id)->decrement($field, $step);
        }catch (Exception $exception){
            throw new AppException("递减失败:".$exception->getMessage(), $this->exceptionCode);
        }
    }


    /**
     * 缓存
     * @param $uid
     * @param null $value
     * @return mixed
     */
    private function cache($uid, $value = null)
    {
        $uuid = $this->model.'_'.$uid;
        if (is_array($value) === false || count($value) == 0) {
            // 获取
            return unserialize(array_get(self::$_cache, $uuid, serialize([])));
        }
        // 添加 or 更新
        $old = unserialize(array_get(self::$_cache, $uuid, serialize([])));
        $new = array_merge($old, $value);

        self::$_cache = array_merge(self::$_cache,[
            $uuid => serialize($new)
        ]);
        return $new;
    }

    /**
     * @param $uid
     * @param $data
     * @return array|mixed
     */
    private function clearCache($uid, $data){
        $uuid = $this->model.'_'.$uid;
        // 添加 or 更新
        unset(self::$_cache[$uuid]);
        return $data;
    }

}