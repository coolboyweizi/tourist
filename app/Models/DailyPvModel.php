<?php

namespace App\Models;

use App\Models\BaseModel as Model;
class DailyPvModel extends Model
{
    protected $table = 'daily_pv';

    protected $fillable = ['times','dated'];
}
