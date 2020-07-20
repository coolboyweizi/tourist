<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Notifications\AppOrder;
use App\Traits\Notice;
use App\Events\AppOrderEvent;


class TalentOrderModel extends Model
{
    use Notice;

    protected $table = 'talent_order';

    /**
     * 所属的商品
     * @var string
     */
    public $app = 'talent';

    /**
     * 通知类型
     * @var string
     */
    private $notification = AppOrder::class;

    protected $dispatchesEvents = [
        'saved' => AppOrderEvent::class
    ];

    protected $fillable = [
       'godate',
        'uid',
        'app_id',
        'price_id',
        'detail',
        'number',
        'money',
        'amount',
        'remark',
        'umobile',
        'username',
        'status',
        'shared',
        'talent',
        'active_id'
    ];
}
