<?php
/**
 * User: 陈宇凡
 * Date: 2018/11/22 0022
 * Time: 17:15
 */

namespace App\Models;

use App\Models\BaseModel as Model;
use Laravel\Scout\Searchable;

class HotelPriceModel extends Model
{
    use Searchable;

    public function toSearchableArray()
    {

        return [
            'title' => $this->getAttribute('title'),
            'price' => $this->getAttribute('price')
        ];
    }

    /**
     * @var string table name
     */
    protected $table='hotel_price';

    protected $fillable = [
        'app_id',
        'thumbs',
        'title',
        'price',
        'tags',
        'type' ,
        'priority',
        'status',
    ];

}