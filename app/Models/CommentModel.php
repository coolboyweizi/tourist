<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Laravel\Scout\Searchable;
class CommentModel extends Model
{
    use Searchable;
    protected $table = "comment";
    /**
     * @return string
     */
    public function getService(){
        return 'comment';
    }

    public function toSearchableArray()
    {
        self::findOrFail();
        return [
            'data' => $this->getAttribute('data')
        ];
    }

    protected $fillable = [
        'uid' ,
        'app',
        'app_id',
        'order_id',
        'thumbs',
        'data',
        'stars',
        'status',
    ];
}
