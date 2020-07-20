<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use Carbon\Carbon;
use Exception;

class AppPriceLogic
{
    /**
     * 关联appinfo
     * @var array
     */
    private static $appInfo = [];

    /**
     * app类型
     * @var
     */
    private $app ;

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
            $appInfo = $this->appService->findById(
                array_get($data, 'app_id')
            );
            if ($appInfo['status'] == 0) {
                $data['status'] = 0;
            }
        } catch (Exception $exception) {
            throw new Exception($exception);
        }
        return $data;
    }

    /**
     * 单个数据查询后置操作
     * @param $data
     * @return array
     */
    public function _after_find($data)
    {
        return array_merge(
            $data,
            $this->appInfo($data),
            $this->activePrice($data)
        );
    }

    /**
     * 分页查询。补充数据操作
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList)
    {
        $items = $pageList['data'];
        foreach ($items as $key => $item) {
            $item = (array) $item;
            $items[$key] = array_merge(
                $item,
                $this->appInfo($item),
                $this->activePrice($item)
            );
        }
        return [
            'data' => $items
        ];
    }

    /**
     * 查询更多有关于APP信息
     * @param $item
     * @return array
     */
    public function appInfo($item)
    {
        try {
            $appId = array_get($item, 'app_id');
            $appInfo = array_get(
                self::$appInfo,
                $appId,
                null
            );
            if ($appInfo == null) {
                $appInfo = $this->appService->findById(
                    $appId
                );
                self::$appInfo[$appId] = $appInfo;
            }
            return [
                'merchant_id' => $appInfo['merchant_id']??0,
                'talent' => $appInfo['uid']??0,
                'appLogo' => $appInfo['logo'],
                'appTitle' => $appInfo['title'],
                'appId' => $appInfo['id'],
                'appComment' => $appInfo['comment'],
                'appMinPrice' => $appInfo['minPrice'],
                'isFavorite' => $appInfo['isFavorite'],
                'avg' => $appInfo['avg'],
                'starCoin' => $appInfo['starCoin'],
                'appAlias' => $appInfo['appAlias'],
                'status'   => $appInfo['status'] == 0 ? 0 : $item['status'],

            ];

        } catch (Exception $exception) {

            return [
                'merchant_id' => 0,
                'appLogo' => $exception->getMessage(),
                'appTitle' =>"项目已下架或不存在",
                'appId' => 0,
                'appComment' => 0,
                'appMinPrice' => 0,
                'isFavorite' => 0,
                'avg' => 0,
                'startCoin' => '',
                'appAlias' => 'no alias found',

            ];
        }
    }

    /**
     * 获取最近30天价格
     * @param $item
     * @return mixed
     */
    private function activePrice($item){
        // 保存默认价格
        $default = $item['price'];

        // 查询30内的活动价格
        $days = 30 ;
        $data = app('active.abstract')->priceDate($item['id'],$this->app,$days);

        // 填充近30天的价格
        $instance = Carbon::now();
        $last=[];
        for ($i=0; $i<$days; $i++){
            $date = $instance->format('Y-m-d');
            $last[$date] = array_get($data['date2price'],$date,['price'=>$default,'active_id'=>0]);
            $instance->addDay();
        }
        // 判断今日价格
        $new = $last[Carbon::now()->format('Y-m-d')];
        $item['old'] = $default;
        $item['price'] = $new['price'];
        $item['active_id'] = $new['active_id']??0;
        $item['latest'] = $last;
        return $item;
    }

}