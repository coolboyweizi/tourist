<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '达人用户',
    'model' => \App\Models\TalentUserModel::class,
    'closure' => [
        '_after_find_all' => function($pageList){
            $items = $pageList['data'];
            foreach ($items as $key=>$item){
                $user = app('user.abstract')->findById($item['uid']);
                $group = app('talentGroup.abstract')->findById($item['gid']);
                $items[$key] = array_merge(
                    $item,
                    [
                        'userAvatar' => $user['avatar'],
                        'nickName' => $user['nickname'],
                        'groupName' => $group['name'],
                        'groupScale' => $group['scale']
                    ]
                );
            }
            return [
                'data' => $items
            ];
        },
        '_after_find' => function($item){
            $user = app('user.abstract')->findById($item['uid']);
            $group = app('talentGroup.abstract')->findById($item['gid']);
            return array_merge(
                $item,
                [
                    'userAvatar' => $user['avatar'],
                    'nickName' => $user['nickname'],
                    'groupName' => $group['name'],
                    'groupScale' => $group['scale']
                ]
            );
        }
    ],
    'query'=>[

    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TALENT_USER_SERVICE_EXCEPTION,
];