<?php

namespace App\Models;

use App\Events\MoneyLogEvent;
use App\Models\BaseModel as Model;
use App\Traits\Notice;

class MoneyLogModel extends Model
{
    use Notice;

    protected $table = 'users_money_log';

    protected $dispatchesEvents = [
        'saved' => MoneyLogEvent::class,
    ];

    /**
     * 可填充字段
     * @var array
     */
    protected $fillable = [
        'uid', 'amount', 'affect','app','app_id','remark','freeze'
    ];
}
