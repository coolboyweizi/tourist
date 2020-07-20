<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '达人定制',
    'model' => \App\Models\TalentModel::class,
    'closure' => [
        '_after_find' => function($pageList){
            return cache_instance(\App\Logic\AppLogic::class,'talent')->_after_find($pageList);
        },
        '_before_create' => function($data) {
            // 用户查询
            $user = app('user.abstract')->findById($data['uid']);
            if ($user['talent'] < 1) {
                throw new Exception("非达人用户");
            }
            // 计算两天的时间
            $stime = \Carbon\Carbon::createFromDate(date('Y', $data['stime']),date('m', $data['stime']),date('d', $data['stime']));
            $etime = \Carbon\Carbon::createFromDate(date('Y', $data['etime']),date('m', $data['etime']),date('d', $data['etime']));

            return [
                'days' => $stime->diffInDays($etime),
                'status' => 1,      // 默认需要审核
                'logo' =>  env('APP_URL').'/rtimg2.png' ,     // 定制的缩略图
                'details' => env('APP_URL').'/rtimg2.png',
                'thumbs' => \GuzzleHttp\json_encode([env('APP_URL').'/rtimg2.png',env('APP_URL').'/rtimg2.png',env('APP_URL').'/rtimg2.png']),
            ];
        },
        '_after_find_all' => function($data)
        {
            $result =  cache_instance(\App\Logic\AppLogic::class,'talent')->_after_find_all($data);
            $items = $result['data'];
            $userInfo = [];
            foreach ($items as $key => $item) {
                if(($user = array_get($userInfo,$item['uid'], false)) === false) {
                    $user = app('user.abstract')->findById($item['uid']);
                    $userInfo = array_merge($userInfo,[
                        $item['uid'] => $user
                    ]);
                }
                $items[$key] = array_merge(
                    $item,[
                    'nickName' => array_get($user,'nickname','no talent user'),
                    'userAvatar' =>     array_get($user,'avatar','no talent user'),
                ]);
            }
            return [
                'data' => $items
            ];
        },
        '_after_create' => function($data) {
            \App\Jobs\TalentPrice::dispatch($data['id']);
            return $data;
        }
    ],
    'query'=>[
        ['status', \Illuminate\Http\Request::capture()->input('status')],
        ['uid',\Illuminate\Http\Request::capture()->input('uid')]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TALENT_SERVICE_EXCEPTION,
];