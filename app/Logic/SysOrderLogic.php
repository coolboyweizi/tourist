<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use App\Exceptions\AppException;
use App\Models\OrderModel;
use Illuminate\Database\Eloquent\Model;
use Exception;
class SysOrderLogic
{
    
    /**
     * 查询子订单信息
     * @param $data
     * @return array
     */
    public function _after_find($data){
        return $this->orderInfo($data);
    }

    /**
     * 分页查询子订单信息
     *
     * @param $data
     * @return array
     */
    public function _after_find_all($data){
        $items = $data['data'];
        foreach ($items as $key=>$item){
            $item = (array) $item;
            $item = array_merge(
                $item,
                $this->orderInfo($item)
            );
            $items[$key] = $item;
        }
        return [
            'data' => $items
        ];
    }

    /**
     * 修改前的置前操作
     *
     * @param $ids
     * @param $data
     * @return array
     * @throws AppException
     */
    public function _before_update($ids, $data)
    {
        $status = array_get($data, 'status', false);
        if ($status !== false) {
            if ($status < -2 || $status > 4) {
                throw new AppException("状态异常",1000);
            }

            if ($status === 0 ){
                //throw new $this->serviceException("逆向操作");
            }
        }
        return $data;
    }

    /**
     * 从子订单获取数据
     *
     * @param $data
     * @return mixed
     */
    public function orderInfo($data){
        try {
            $app = array_get($data,'app');
            $order_id = array_get($data, 'order_id');

            $orderService = app($app.'Order.abstract');
            $order_info =  $orderService->findById($order_id);
            // 避免冲突 ，几个字段要处理
            foreach (['id','created','updated'] as $key) {
                unset($order_info[$key]);
            }
            return $order_info;
        }catch (Exception $e){
            return [
                'money'=>0,
                'amount'=>0,
                'appAlias'=>'项目不可用',
                'appTitle'=>'项目不可用',
                'appLogo'=>'https://119.23.241.122/xysd/yujian-images/raw/6587a70553fd94bfda1e5d8c186b293cc20d1a7f/16pic_4524591_b.jpg',
                'remark'=>'项目不可用',
                'avatar'=>'https://119.23.241.122/xysd/yujian-images/raw/6587a70553fd94bfda1e5d8c186b293cc20d1a7f/16pic_4524591_b.jpg',
                'nickname'=>'项目不可用',
                'statusCn'=>'项目不可用'
            ];
        }
    }

    /**
     * 根据子订单的Model查询相关系统订单
     * @param Model $order
     * @return int
     */
    public function getDataFromModel(Model $order){
        $models = OrderModel::where('order_id' , $order->id)
            ->where('app', $order->getService())
            ->get();
        foreach ($models as $model) {
            return $model->toJson();
        }
        return 0;
    }

    /**
     * 监听来组AppOrder的信息同步.初始化和status
     *
     * @param Model $order
     * @return int
     * @throws \Exception
     */
    public function SyncDataFromModel(Model $order, int $id){
        $data = [
            'uid' => $order->uid,
            'app' => $order->getService(),
            'order_id' => $order->getKey(),
            'detail' => $order->detail,
            'talent' => $order->talent,
            'shared' => $order->shared,
            'status' => $order->status ?:0,
            'active_id' => $order->active_id??0,
        ];

        return $id > 0 ?
            OrderModel::find($id)->update($data):
            OrderModel::create($data);
    }
}