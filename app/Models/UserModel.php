<?php

/**
 * 微信用户提供其
 */
namespace App\Models;

use Illuminate\Foundation\Auth\User;
use \Illuminate\Auth\Authenticatable ;


class UserModel extends User
{
    use Authenticatable;

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'created';

    /**
     * The name of the "updated at" column.
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

    protected $fillable = [
       'talent', 'opendid','avatar','city','province','nickname','gender','session_key','amount','freeze'
    ];

    protected $hidden = [
        'deleted'
    ];

    protected $table = 'users';

}
