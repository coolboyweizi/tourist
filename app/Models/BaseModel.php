<?php

namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class BaseModel extends Model
{
    protected $dates = [
        'created',
        'updated',
        'deleted'
    ];


    /**
     * Soft DELETE
     */
    use SoftDeletes;

    /**
     * @var array
     */
    const DELETED_AT = 'deleted';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * The name of the "updateed at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updated';

    /**
     * @param \DateTime|int $value
     * @return false|int
     * @author dividez
     */
    public function fromDateTime($value){
        return strtotime($value);
    }

    /**
     * 返回模型的UID。如果没有则为0
     * @return mixed
     */
    public function getUid(){
        $attrs = $this->getAttributes();
        return array_get($attrs,'uid', 0);
    }

    public function doNotify(){
        if (method_exists($this,'notice')) {
            $this->notice();
        }
        return $this;
    }
}

