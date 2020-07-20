<?php

namespace App\Models;

use App\Models\BaseModel as Model;

class ActiveModel extends Model
{
    protected $table = 'active';

    public function getStimeAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['stime']);
    }

    public function getEtimeAttribute()
    {
        return date('Y-m-d H:i:s', $this->attributes['etime']);
    }


    protected $fillable = [
      'app','price_id','price','date','stime','etime','date','week','remark','number','status'
    ];
}
