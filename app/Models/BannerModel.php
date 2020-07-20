<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\12\14 0014
 * Time: 16:33
 */

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Events\Recommend\SavedEvent;
use App\Events\Recommend\DeletedEvent;
class BannerModel extends Model
{
    protected $dispatchesEvents = [
        'saved' => SavedEvent::class,
        'deleted' => DeletedEvent::class
    ];
    protected $table = 'banner';
}