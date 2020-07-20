<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use App\Exceptions\AppException;
use Exception;

class RecommendLogic
{
    /**
     * app类型
     * @var
     */
    public $app ;

    /**
     * 关联的app service
     * @var null
     */
    private $appService = null;

    /**
     * AppPriceService constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->appService = app($app.'.abstract');
    }

    /**
     * 前置添加，判断状态
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function _before_create($data)
    {
        try {
            $reson = array_get($data,'data','');
            $data = array_merge($data,[
                'data' => $reson == ''?'官方推荐':$reson
            ]);
            // 检查 Project状态
            $item = app($data['app'].'.abstract')->findById($data['app_id']);
            // 项目已经被推荐，检查是否推荐正常
            if ($item['recommend'] > 0) {
                // 发现项目已经添加，则检查recommend是否匹配app_id

                try {
                    // 检查推荐信息.如果app
                    $recommend = app('recommend.abstract')->findById($item['recommend']);

                    // 信息不匹配。都清楚
                    if ($recommend['app_id'] != $item['app_id'] || $recommend['app'] != $data['app'] ) {
                        app('recommend.abstract')->destroy([$recommend['app_id']]);
                        app($data['app'].'.abstract')->update([$data['app_id']],['recommend'=>0]);
                        return $data;
                    }else {
                        throw new Exception('重复添加');
                    }
                }catch (AppException $exception) {
                    // app的recommend没有，那么清零
                    app($data['app'].'.abstract')->update([$data['app_id']],['recommend' => 0]);
                    return $data;
                }

            }

            // 检查recommend状态。即recommend有，但是没有同步
            $limit = 100;
            while($limit > 0) {
                $items = app('recommend.abstract')->findAll( [
                    ['app' ,$data['app']],
                    ['app_id' , $data['app_id']]
                ],$limit);
                $ids = [];
                foreach ($items['data'] as $datum) {
                    array_push($ids, $datum['id']);
                }
                app('recommend.abstract')->destroy($ids);
                $limit = ($items['total'] > $limit)?$limit:$items['total'];
            }
            return $data;

        }catch (AppException $exception){
            throw new AppException($exception->getMessage());
        }

    }

    /**
     * 添加完成后，返回项目相关信息
     * @param $data
     * @return mixed
     */
    public function _after_create($data){
        app($data['app'].'.abstract')->update([$data['app_id']],['recommend' => $data['id']]);
        return $data;
    }

    /**
     * 分页查询。补充数据操作
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList)
    {
        $items = array_get($pageList,'data');
        $appServiceInstance = [];
        foreach ($items as $key=>$item){
            $app = array_get($item,'app');
            $app_id = array_get($item,'app_id');
            $appService = array_get($appServiceInstance, $app, null);
            if ($appService == null ) {
                $appService = app($app.'.abstract');
                $appServiceInstance[$app] = $appService;
            }
            $appInfo = $appService->findById($app_id);
            $items[$key] = array_merge(
                $item,[
                'appTitle' => $appInfo['title'],
                'appAlias' => $appInfo['appAlias'],
                'appLogo' => $appInfo['logo'],
                'minPrice' => $appInfo['minPrice']
            ]);
        }
        return ['data' =>$items];
    }

    /**
     * 取消推荐前，删除app的recommend
     * @param $ids
     * @return mixed
     */
    public function _before_destroy($ids){
        foreach ($ids as $id ){
            $data = app('recommend.abstract')->findById($id);
            app($data['app'].'.abstract')->update([$data['app_id']],['recommend' => 0]);
        }
        return $ids;
    }

}