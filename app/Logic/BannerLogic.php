<?php

namespace App\Logic;


class BannerLogic
{

    /**
     * 推荐列表 填充数据字段
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList){
        $items = $pageList['data'];
        foreach ($items as $k => $v) {
            $items[$k] = array_merge(
                $v,
                $this->appInfo($v)
            );
        }
        return array_merge(
            $pageList,
            [
                'data' => $items
            ]
        );
    }

    /**
     * Banner 字段数据赋值
     * @param $data
     * @return array
     */
    private function appInfo($data){
        return [
            'banner' => array_get($data,'thumb')
        ];
    }

}