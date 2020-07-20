<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\1\4 0004
 * Time: 9:36
 */

namespace App\Models;


use App\Events\AppOrderEvent;
use App\Notifications\AppOrder;
use App\Traits\Notice;
use App\Models\BaseModel as Model;


class TravelOrderModel extends Model
{
    /**
     * 消息通知模块
     */
    use Notice;

    /**
     * @var string table name
     */
    protected $table='travel_order';

    /**
     * @var string
     */
    public $app = 'travel';

    /**
     * 事件关联
     * @var array
     */
    protected $dispatchesEvents = [
       'saved' => AppOrderEvent::class
    ];

    private $notification = AppOrder::class;


    /**
     * @var int 订单ID
     */
    private $price_id = 0;

    /**
     * @return string
     */
    public function getService(){
        return $this->app;
    }

    /**
     * get primary key id from
     * @return int
     */
    public function getAppId(){
        return $this->app_id;
    }

    /**
     * @param $value
     * @return int
     */
    public function setUsetimeAttribute($value){
        if (strpos($value,'-') > 0) {
            $this->attributes['usetime'] = strtotime($value);
        }else {
            $this->attributes['usetime'] = $value;
        }
    }
    public function getUsetimeAttribute(){
        return date('Y-m-d', $this->attributes['usetime']);
    }


    protected $fillable = [
        'uid',
        'app_id',
        'price_id',
        'detail',
        'number' ,
        'money',
        'amount',
        'remark',
        'schedule',
        'godate',
        'pcode' ,
        'tel',
        'status' ,
        'iscomment',
        'talent',
        'shared',
        'apiShortUrl',
        'apiTag',
        'apiOrder',
        'apiNumber'
    ];
}