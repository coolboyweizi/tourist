<?php

namespace App\Models;

use App\Models\BaseModel as Model;


class ProfitModel extends Model
{
    /**
     * 收益table
     * @var string
     */
    protected $table = 'profit';

    /**
     * @var array
     */
    protected $fillable = [
        'merchant_id',
        'remark',
        'order_id',
        'app',
        'sale',
        'shared_uid',
        'talent_uid',
        'system',
        'shared',
        'talent',
        'merchant'
    ];

    public function order(){
        return $this->belongsTo('App\Models\OrderModel','order_id');
    }
}
