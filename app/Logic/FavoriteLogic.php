<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use Exception;
use Illuminate\Support\Facades\Auth;

class FavoriteLogic
{

    /**
     * 关注检查
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function _before_create($data)
    {
        // 检查app的应用状态
        $appInfo = $this->moreApp($data);
        if (empty($appInfo)) {
            throw new Exception("您关注的项目状态已下架或不存在");
        }
        // 是否关注
        $favoriteInfo = app('favorite.abstract')->findAll(
            [
                'app' => array_get($data,'app'),
                'app_id' => array_get($data,'app_id'),
                'uid' => Auth::id()?:1
            ],
            1000
        );
        // 查找第一条
        $favoriteInfo = array_get(
            array_get($favoriteInfo,'data',null),
            0,
            null
        );
        // 已经关注则报错
        if (array_get($favoriteInfo,'status', 0) > 0) {
            throw new Exception("您已经关注该项目",-1);
        }

        return [
            'status' => array_get($data,'status',1)?:0,
            'remark' => trim(array_get($data,'remark',''))?:'备注'
        ];
    }

    /**
     * 数据填充
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList){
        $items = array_get($pageList,'data');
        foreach ($items as $key=>$val) {
            $items[$key] = array_merge(
                $val,
                $this->moreApp($val)
            );
        }
        return [
            'data' => $items,
        ];
    }

    /**
     * 查询详细的App信息
     *
     * @param $data
     * @return array
     */
    public function moreApp($data)
    {
        try {
            $app = array_get(
                $data,
                'app',
                ''
            );
            $app_id = array_get(
                $data,
                'app_id',
                0
            );

            $appService = app($app.'.abstract');
            $appInfo = $appService->findById($app_id);
            return $this->appInfo($appInfo);

        }catch (\Exception $e) {
            return [];
        }
    }

    /**
     * 景区项目返回字段
     * @param $appInfo
     * @return array
     */
    public function appInfo($appInfo){
        return [
            'appLogo' => $appInfo['logo'],
            'appTitle' => $appInfo['title'],
            'minPrice' => $appInfo['minPrice'],
            'appOrder' => $appInfo['ordered'],
            'appComment' => $appInfo['comment'],
            'appTagsA' => $appInfo['tagsA']??'',
            'appTagsB' => $appInfo['tagsB']??'',
            'appAddress' =>  array_get($appInfo,'address','No Address'),
        ];
    }
}