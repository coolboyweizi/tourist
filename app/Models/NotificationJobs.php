<?php

namespace App\Models;

use App\Models\BaseModel as Model;
class NotificationJobs extends Model
{
    protected $table = 'notification_jobs';

    protected $fillable = [
        'jobs',
        'exception'
    ];
}
