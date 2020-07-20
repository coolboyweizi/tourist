<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '达人用户组',
    'model' => \App\Models\TalentGroupModel::class,
    'closure' => [
    ],
    'query'=>[

    ],
    'errorCode' => \App\Exceptions\ExceptionCode::TALENT_GROUP_SERVICE_EXCEPTION,
];