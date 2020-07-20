<?php
/**
 * User: mk
 * Date: 2018/11/22 0022
 * Time: 16:38
 */

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Notifications\AppOrder;
use App\Traits\Notice;
use App\Events\AppOrderEvent ;

class HotelOrderModel extends Model
{
    /**
     * Use Notice
     */
    use Notice;

    /**
     * @var string table name
     */
    protected $table='hotel_order';


    private $notification = AppOrder::class;

    protected $dispatchesEvents = [
        'saved' => AppOrderEvent::class
    ];

    /**
     * app类型
     * @var string
     */
    public $app = 'hotel';

    /**
     * 格式化使用时间
     * @param $value
     */
    public function setUstimeAttribute($value)
    {
        if (strpos($value,'-') > 0) {
            $this->attributes['ustime'] = strtotime($value);
        }else {
            $this->attributes['ustime'] = $value;
        }
    }

    /**
     * 格式化时间
     * @param $value
     */
    public function setUetimeAttribute($value){
        if (strpos($value,'-') > 0) {
            $this->attributes['uetime'] = strtotime($value);
        }else {
            $this->attributes['uetime'] = $value;
        }
    }

    /**
     * 格式化时间
     * @return false|string
     */
    public function getUstimeAttribute(){
        return date('Y-m-d', $this->attributes['ustime']);
    }

    /**
     * 格式化时间
     * @return false|string
     */
    public function getUetimeAttribute(){
        return date('Y-m-d', $this->attributes['uetime']);
    }

    protected $fillable = [
        'uid',
        'app_id',
        'price_id',
        'detail',
        'number',     // 购买数量
        'money',   // 单价
        'amount' ,    // 订单总额
        'remark',
        'ustime', // 用户入驻时间
        'uetime' ,
        'status',
        'username',
        'umobile',
        'talent',
        'shared' ,
        'iscomment',
        'active_id'
    ];
}