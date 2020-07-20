<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Laravel\Scout\Searchable;

class TravelModel extends Model
{
    use Searchable;

    protected $table = 'travel';

    /**
     * 搜索
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->getAttribute('title'),
            'detail' => $this->getAttribute('detail')
        ];
    }


    protected $fillable = [
        'title',
        'thumbs',
        'logo',
        'detail',
        'destination',
        'departure',
        'pcode',
        'ptype',
        'status' ,
        'comment',
        'ordered',
        'recommend',
        'tagsA' ,
        'tagsB',
        'tagsC',
    ];
}
