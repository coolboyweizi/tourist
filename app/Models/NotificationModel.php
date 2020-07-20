<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class NotificationModel extends Model
{
    protected $table = 'notification';

    protected $fillable = [
        'uid',
        'type',
        'data',
        'read',
    ];
}
