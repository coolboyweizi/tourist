<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class SearchRecordModel extends Model
{
    /**
     * @var string
     */
    protected $table = 'search_record';

    /**
     * @var array
     */
    protected $fillable = [
      'app','keywords','count','times'
    ];
}
