<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class FavoriteModel extends Model
{
    protected $table = 'favorite';

    protected $fillable = ['uid','app','app_id','status','remark'];
}
