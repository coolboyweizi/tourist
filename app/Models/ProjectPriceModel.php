<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Laravel\Scout\Searchable;

class ProjectPriceModel extends Model
{
    use Searchable;

    protected $table = 'project_price';

    public function getStimeAttribute()
    {
        return date('Y-m-d', $this->attributes['stime']);
    }

    public function getEtimeAttribute()
    {
        return date('Y-m-d', $this->attributes['etime']);
    }

    public function setEtimeAttribute($value){
        if (strpos($value,'-') > 0) {
            $this->attributes['etime'] = strtotime($value);
        }else {
            $this->attributes['etime'] = $value;
        }
    }

    public function setStimeAttribute($value){
        if (strpos($value,'-') > 0) {
            $this->attributes['stime'] = strtotime($value);
        }else {
            $this->attributes['stime'] = $value;
        }
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->getAttribute('title'),
            'price' => $this->getAttribute('price'),
            'type'  => $this->getAttribute('type'),
        ];
    }

    protected $fillable =[
        'id',
        'uid',
        'app_id',
        'title',
        'price',
        'unit',
        'tips',
        'status',
        'type',
        'priority',
        'stime',
        'etime'
    ];
}
