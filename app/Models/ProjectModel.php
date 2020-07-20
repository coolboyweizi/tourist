<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Events\AppService\SavedEvent;
use App\Events\AppService\DeleteEvent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class ProjectModel extends Model
{

    use Searchable;


    /**
     * @var string table name
     */
    protected $table = "project";

    /**
     * Event Dispatch
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => SavedEvent::class,
        //'saved' => SavedEvent::class,
        'deleted' => DeleteEvent::class
    ];

    /**
     * @return string
     */
    public function getService(){
        return 'project';
    }

    /**
     * get primary key id from
     * @return int
     */
    public function getAppId(){
        return $this->getKey();
    }

    /**
     * 搜索
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
        'uid' ,
        'title',
        'thumbs',
        'logo',
        'detail',
        'address',
        'status' ,
        'opentime',
        'comment' ,
        'recommend',
        'notice',
        'illustrate',
        'ordered',
        'tagsA' ,
        'tagsB' ,
        'tagsC' ,
        'merchant_id'
    ];
}
