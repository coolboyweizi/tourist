<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class TalentUserModel extends Model
{
    protected $table = 'talent_user';

    protected $fillable = ['uid','gid',];
}
