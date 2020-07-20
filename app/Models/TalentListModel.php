<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class TalentListModel extends Model
{
    protected $table = 'talent_list';

    protected $fillable = [
      'talent_id','app','price_id','number'
    ];
}
