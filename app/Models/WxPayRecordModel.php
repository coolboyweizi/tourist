<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class WxPayRecordModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'wx_pay_call_record';

    /**
     * @var array 填充字段
     */
    protected $fillable = [
        'status', 'openid', "nickname", 'result_code', "time_end", 'total_fee', "out_trade_no"
    ];
}
