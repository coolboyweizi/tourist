<?php

namespace App\Models;

use App\Events\MerchantMoneyLogEvent;
use App\Models\BaseModel as Model;

class MerchantMoneyLogModel extends Model
{
    protected $table = 'merchant_money_log';

    protected $dispatchesEvents = [
      'created' => MerchantMoneyLogEvent::class
    ];

    protected $fillable = [
        'merchant_id','affect','amount','app','app_id','remark','freeze'
    ];

}
