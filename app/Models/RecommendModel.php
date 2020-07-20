<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Laravel\Scout\Searchable;

class RecommendModel extends Model
{
    use Searchable;
    
    protected $table = 'recommend';

    protected $fillable =[
        'app',
        'app_id',
        'data',
        'priority'
    ];
}
