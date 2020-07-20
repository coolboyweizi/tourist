<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class TalentGroupModel extends Model
{
    protected $table = 'talent_group';

    protected $fillable = ['name','status','scale'];
}
