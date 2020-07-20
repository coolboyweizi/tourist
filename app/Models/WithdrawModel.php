<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\Notice;
use Laravel\Scout\Searchable;


class WithdrawModel extends Model
{
    use Searchable;

    use Notice;
    /**
     * Model Mapping Table Name
     * @var string
     */
    protected $table='withdraw';


    /**
     * Return Which Service Model
     *
     * @return string
     */
    public function getService()
    {
        return 'withDraw';
    }

    protected $fillable = ['uid','money','status'];

}
