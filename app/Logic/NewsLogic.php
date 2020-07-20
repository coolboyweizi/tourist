<?php
/**
 * User: fufanghuan
 * Date: 2018/12/10
 * Time: 15:12
 */

namespace App\Logic;

use DB;

class NewsLogic
{
    /**
     * 查询所有
     */
    public function _after_find_all($pageList){
        $items = $pageList['data'];
        foreach ($items as $key => $val) {
            $val = (array) $val;
            $items[$key] = array_merge(
                $val,
                $this->moreData($val)
            );
        }
        return [
            'data'=>$items
        ];
    }

    /**
     * @param $data
     * @return array
     */
    public function _after_find($data){
        $id = array_get($data,'id');
        DB::table('articles')->where('id',$id)->increment('click');
        return array_merge(
            $data,
            $this->moreData($data)
        );
    }
    /**
     * @param $data
     * @return array
     */
    public function moreData($data){
        return [
            'title'     =>array_get($data,'title'),
            'thumbs'    =>array_get($data,'thumb'),
            'content'   =>array_get($data,'content'),
            'read'      =>array_get($data,'click'),
            'created'   =>array_get($data,'created_at')
        ];
    }
}