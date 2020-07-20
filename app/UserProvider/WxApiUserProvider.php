<?php
/**
 * 微信用户提供器。
 * 1、根据openid查询用户基础信息
 * 2、如果没有基础用户信息，创建并返回
 * 3、没有登录异常情况，只要微信验证过即可
 * 4、该用户提供目前只适用于微信小程序，配个WeChatUser看守器配个使用
 * User: Master King
 * Date: 2018/11/29
 */

namespace App\UserProvider;

use App\Models\UserModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class WxApiUserProvider implements UserProvider
{

    /**
     * 根据OpenId返回一条用户数据。此处返回是一个带有Authenticatable实现的UserModel模型
     * @param mixed $identifier
     * @return Authenticatable|null
     */
    public function retrieveById($identifier)
    {
        return UserModel::where('opendid', $identifier)->first();
    }


    // 根据Token 返回对象
    public function retrieveByToken($identifier, $token)
    {

    }

    // 更新Token
    public function updateRememberToken(Authenticatable $user, $token)
    {

    }

    /**
     * 验证的时候，需要提供openid和uid
     * @param array $credentials
     * @return Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        return UserModel::where([
            'session_key' => $credentials['session_key']
        ])->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        // TODO: Implement validateCredentials() method.
    }

}