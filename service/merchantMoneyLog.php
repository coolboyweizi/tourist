<?php
/**
 * User: Master King
 * Date: 2019/1/9
 */

return [
    'alias' => '商家资金日志',
    'model' =>\App\Models\MerchantMoneyLogModel::class,
    'query'=>[
        ['admin_id',\Illuminate\Http\Request::capture()->input('admin_id')]
    ],
    'errorCode' => \App\Exceptions\ExceptionCode::MERCHANT_MONEY_LOG_SERVICE
];