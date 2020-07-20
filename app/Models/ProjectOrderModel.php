<?php

namespace App\Models;

use App\Events\AppOrderEvent;
use App\Models\BaseModel as Model;

use App\Notifications\AppOrder;
use App\Traits\Notice;

class ProjectOrderModel extends Model
{
    /**
     * Use Notice
     */
    use Notice;

    /**
     * 所属类型
     * @var string
     */
    public $app = 'project';

    /**
     * Table Name
     *
     * @var string
     */
    protected $table = 'project_order';


    /**
     * 消息通知
     * @var string
     */
    private $notification = AppOrder::class;


    protected $dispatchesEvents = [
        'saved' => AppOrderEvent::class
    ];

    /**
     * 格式化usetime
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

    /**
     * 格式化字段 usetime
     * @return false|string
     */
    public function getUsetimeAttribute(){
        return date('Y-m-d', $this->attributes['usetime']);
    }

    protected $fillable = [
        'uid' ,
        'app_id',
        'price_id',
        'detail',
        'number' , // 数量
        'money' ,
        'amount',
        'remark', // 备注
        'usetime' , // 出行时间
        'umobile', // 预留手机号
        'iscomment',
        'talent',
        'shared',
        'status',
        'active_id'
    ];
}
