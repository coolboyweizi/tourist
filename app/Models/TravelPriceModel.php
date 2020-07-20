<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class TravelPriceModel extends Model
{
    protected $table = 'travel_price';

    protected $fillable = [
        'app_id',
        'pcode',
        'title',
        'price',
        'type',
        'unit',
        'godate',
        'schedule',
        'seats',
        'occupiedseats',
        'priority',
        'status',
        'backdate',
        'backSchedule'
    ];

}
