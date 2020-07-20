<?php
/**
 * User: 陈宇凡
 * Date: 2018/11/22 0022
 * Time: 15:32
 */

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Events\AppService\SavedEvent;
use App\Events\AppService\DeleteEvent;

use Laravel\Scout\Searchable;

class HotelModel extends Model
{
    use Searchable;

    /**
     * @var string table name
     */
    protected $table = 'hotel';

    /**
     * Event Dispatch
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => SavedEvent::class,
        'saved' => SavedEvent::class,
        'deleted' => DeleteEvent::class
    ];

    protected $dates = ['deleted'];


    /**
     * @return string
     */
    public function getService(){
        return 'hotel';
    }

    /**
     * get primary key id from
     * @return int
     */
    public function getAppId(){
        return $this->getKey();
    }

    /**
     *
     * @return array
     */
    public function toSearchableArray()
    {

        return [
            'id' => $this->getKey(),
            'title' => $this->getAttribute('title'),
            'detail' => $this->getAttribute('detail')
        ];
    }

    protected $fillable = [
        'uid',
        'logo',
        'thumbs',
        'status',
        'title',
        'detail',
        'address',
        'notice',
        'illustrate',
        'ordered',
        'comment' ,
        'recommend',
        'tagsA' ,
        'tagsB',
        'tagsC',
        'merchant_id'
    ];
}