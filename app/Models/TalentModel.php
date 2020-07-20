<?php

namespace App\Models;

use App\Models\BaseModel as Model;
class TalentModel extends Model
{
    protected $table = 'talent';

    protected $fillable = [
      'uid','title','departure','destination','stime','etime','days','illustrate','status','logo','thumbs','recommend','detail'
    ];
}
