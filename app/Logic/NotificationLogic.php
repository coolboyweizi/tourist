<?php
/**
 * User: Master King
 * Date: 2018/11/19
 */

namespace App\Logic;

use Exception;

class NotificationLogic
{
    /**
     * 对应的图标
     * @var array
     */
    private $thumbs = [
        'system'    => 'newimg1.png',
        'money'     => 'newimg3.png',
        'comment'   => 'newimg6.png',
        'order'     => 'newimg5.png',
    ];

    /**
     * 别名
     * @var array
     */
    private $alias = [
        'system'    => '系统通知',
        'money'     => '账户通知',
        'comment'   => '评论通知',
        'order'     => '订单通知',
    ];

    /**
     * 保存用户数据
     * @var array
     */
    private static $userInfo = [];


    /**
     * 单个查询后
     * @param $data
     * @return mixed
     */
    public function _after_find($data)
    {
        $type = array_get($data, 'type', 'system');
        $data['logoUrl'] = $this->getLogoUrl($type);
        $data['alias'] = $this->getAlias($type);
        return $data;
    }

    /**
     * 具体单个分类通知列表
     * @param $data
     * @return array
     */
    public function _after_find_all($data){
        $items = $data['data'];
        foreach ($items as $key => $item) {
            $items[$key] = array_merge(
                $item,
                [
                    'logoUrl' => env('APP_URL').'/'.$this->thumbs[$item['type']],
                    'alias' => array_get($this->alias, $item['type']),
                    'title' => array_get($item,'title','此处默认标题'),
                ],
                $this->userInfo($item)
            );
            //$type = array_get($item, 'type');
        }
        return $data;
    }

    /**
     * 用户通知概览未读消息
     * alias data  logoUrl total type
     */
    public function overView($uid){
       $return = [];
       array_walk($this->alias,function ($alias,$type) use(&$return, $uid){
             $result = app('notification.abstract')->findAll([
                 ['type',$type],
                 ['read',0],
                 ['uid',$uid]
             ],1);

             $return = array_merge($return,[
                 $type => [
                     'alias' => $alias,
                     'data'  => array_get($result['data'],0,['data'=>'没有最新消息'])['data'],
                     'total' => $result['total'],
                     'type'  => $type,
                     'logoUrl'=> env('APP_URL').'/'.$this->thumbs[$type]
                 ]
             ]);
       });
       return $return;
    }

    /**
     * @param $type
     * @return string
     */
    public function getLogoUrl($type){
        return env('APP_URL').'/'.$this->thumbs[$type];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getAlias($type) {

        return $this->alias[$type];
    }

    public function userInfo($data) {
        $uid = array_get($data,'uid', 0);

        $userInfo = array_get(self::$userInfo, $uid, false);

        if ($userInfo === false ){
            $userInfo = app('user.abstract')->findById($uid);
            self::$userInfo[$uid] = $userInfo;
        }
        return [
            'userAvatar' =>  $userInfo['avatar'],
            'nickname' => $userInfo['nickname'],
            'userGender'  => $userInfo['gender']
        ];
    }
}