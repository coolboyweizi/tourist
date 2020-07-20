<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Events\Comment\SavedEvent;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $dispatchesEvents = [
        'saved' => SavedEvent::class,
    ];

    public function toSearchableArray()
    {
        self::findOrFail();
        return [
            'data' => $this->getAttribute('data')
        ];
    }

    protected $fillable = [
        'uid',
        'title',
        'thumbs',
        'content',
        'read',
    ];

    protected $denys = [
        'create', 'delete', 'update', 'view'
    ];
}
