<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as UserAuth;
use Illuminate\Auth\Authenticatable;
use Laravel\Scout\Searchable;
use Spatie\Permission\Traits\HasRoles;

class User extends UserAuth
{
    use Notifiable, HasRoles, Searchable, Authenticatable;


    /**
     * The table name
     *
     * @var string
     */
    protected $table = 'admin';

    /**
     * Create Timestamp
     */
    const CREATED_AT = 'created';

    /**
     * Update Timestamp
     */
    const UPDATED_AT = 'updated';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','name', 'email', 'password','phone','uuid','amount','freeze'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @param \DateTime|int $value
     * @return false|int|string
     */
    public function fromDateTime($value){
        return strtotime($value);
    }

}
