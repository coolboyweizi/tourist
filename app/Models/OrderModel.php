<?php
/**
 * User: Master King
 * Date: 2018/11/21
 */

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Events\SysOrderEvent as SavedEvent;
use App\Traits\Notice;
use Laravel\Scout\Searchable;

class OrderModel extends Model
{
    use Searchable;
    use Notice;

    protected $table = 'orders';
    /**
     * 事件分发
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => SavedEvent::class
    ];


    public function toSearchableArray()
    {
        return [
            'id' => $this->getAttribute('id')
        ];
    }
    protected $fillable = [
        'uid',
        'app',
        'order_id' ,
        'detail',
        'talent',
        'shared',
        'status',
        'active_id'
    ];
}
