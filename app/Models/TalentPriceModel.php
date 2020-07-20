<?php

namespace App\Models;

use App\Models\BaseModel as Model;
class TalentPriceModel extends Model
{
    /**
     * 表名
     * @var string
     */
    protected $table = 'talent_price';

    /**
     * 填充表
     * @var string
     */
    protected $fillable = ['app_id','title','price','unit','status'];


}
