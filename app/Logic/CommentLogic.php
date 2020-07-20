<?php
/**
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use App\Models\CommentModel;
use Exception;
use Illuminate\Http\Request;

class CommentLogic
{
    /**
     * 静态数据保存app项目信息
     * @var array
     */
    private static $appInfo = [];

    /**
     * 评论图标
     * @access private
     * @var array
     */
    private static $starImg = [
        '0.0'   => 'scimgon0.png',
        '0.5'   => 'scimgon0.5.png',
        '1.0'   => 'scimgon1.png',
        '1.5'   => 'scimgon1.5.png',
        '2.0'   => 'scimgon2.png',
        '2.5'   => 'scimgon2.5.png',
        '3.0'   => 'scimgon3.png',
        '3.5'   => 'scimgon3.5.png',
        '4.0'   => 'scimgon4.png',
        '4.5'   => 'scimgon4.5.png',
        '5.0'   => 'scimgon5.png',

    ];

    /**
     * 评论置前操作
     *
     * @param $data
     * @return array
     * @throws Exception
     */
    public function _before_create($data){

        $app = array_get($data, 'app');
        $orderService = app($app.'Order.abstract');

        $orderInfo = call_user_func_array([$orderService,
            'findById'],
            [array_get($data,'order_id')]
        );

        if ($orderInfo['iscomment'] > 0 || $orderInfo['status'] > 2) {
            throw new Exception("该订单已经评论");
        }

        if ($orderInfo['status'] != 2 ) {
            throw new Exception("该订单还没有完成");
        }

        return [
            'thumbs' => \GuzzleHttp\json_encode($data['thumbs']),
            'status' => array_get($data,'status',0),
            'app_id' => $orderInfo['appId']
        ];
    }

    /**
     * 添加数据之后，comment自加1
     * @param $data
     * @return array
     */
    public function _after_create($data){
        $instance = app($data['app'].'.abstract');
        $app = $instance->findById($data['app_id']);
        $instance->update(
            [$data['app_id']],[
            'comment' => $app['comment'] + 1
        ]);

        $orderInstance = app($data['app'].'Order.abstract');
       // $order = $orderInstance->findById($data['order_id']);
        $orderInstance->update(
            [$data['order_id']],
            ['status'=>3]
        );

        return $data;
    }

    /**
     * 查询单个评论后的操作
     * @param $data
     * @return array
     * @throws \Exception
     */
    public function _after_find($data){
        return array_merge(
            $data,
            $this->moreApp($data),
            $this->commentUser($data['uid'])
        );
    }

    /**
     * 列表后置操作.
     * @param $pageList
     * @return array
     * @throws \Exception
     */
    public function _after_find_all($pageList){

        foreach ($pageList['data'] as $pos => $item )
        {
            $pageList['data'][$pos] = array_merge(
                $item,
                $this->moreApp($item),
                $this->commentUser($item['uid']),
                ['starsCoin' => $this->starsCoin($item['stars'])]
            );
        }

        $condition = [
          ['status', 1],
          ['thumbs','<>',"[null,null,null]"]
        ];

        $request = Request::capture();
        if ($request->has('app') && $request->has('app_id')) {
            $condition = array_merge(
                $condition,[
                    'app' => $request->input('app'),
                    'app_id' => $request->input('app_id')
            ]);
        }
        return array_merge(
            $pageList,
            [
                'pics' => CommentModel::where($condition)->count(),

                'avg' => sprintf("%.1f",(CommentModel::where($condition)->avg('stars'))),
                'starCoin' => $this->starsCoin(
                    sprintf("%.1f",(CommentModel::where($condition)->avg('stars')))
                )
            ]
        );
    }

    /**
     * 查询详细的App信息
     * @param $data
     * @return array
     */
    private function moreApp($data) {

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

            $order_id = array_get(
                $data,
                'order_id',
                0
            );

            $orderInfo = array_get(
                array_get(self::$appInfo, $app, []),
                $app_id,
                null
            );

            if ($orderInfo === null) {
                $orderService = app($app.'Order.abstract');
                $orderInfo = call_user_func_array([$orderService, 'findById'], [$order_id]);
                self::$appInfo[$app][$app_id] = $orderInfo;
            }
            return [
                'appLogo' => $orderInfo['appLogo'],
                'appAlias' => $orderInfo['appAlias'],
                'appTitle' => $orderInfo['appTitle']
            ];

        }catch (\Exception $e) {
            return [
                'appLogo' =>'项目不可用',
                'appAlias' => '项目不可用',
                'appTitle' =>'项目不可用',

            ];
        }
    }

    /**
     * 评论用户
     * @param $uid
     * @return array
     * @throws \Exception
     */
    private function commentUser($uid){
        $userInfo = app('user.abstract')->findById($uid);
        return [
            'userAvatar' => $userInfo['avatar'],
            'userNickname' => $userInfo['nickname']
        ];
    }
    /**
     * 获取平均分数的coin
     * @param $stars
     * @return string
     */
    private function starsCoin($stars){
        $stars = explode('.', $stars);
        $pos =  isset($stars[1]) ? ($stars[1] >0 ? 5 : 0) : 0;
        return join('/',[
            env('APP_URL'),
            self::$starImg[join('.',[$stars[0], $pos])]
        ]);
    }

}