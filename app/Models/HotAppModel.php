<?php

/**
 * 热门项目
 */
namespace App\Models;

use App\Models\BaseModel as Model;

class HotAppModel extends Model
{
    protected $table = 'hot';

    protected $fillable = [
        'times','app','app_id'
    ];
}
