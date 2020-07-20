<?php
/**
 * 微信用户看守器
 * 0、从用户提供器查询相关数据
 * 1、微信用户请求数据后返回openid。并更新updated时间
 * 2、微信用户通过openid进行数据验证
 *
 * User: Master King
 * Date: 2019/1/15
 */

namespace App\Guards;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Api\WeChatUser;
use App\Models\UserModel;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\SupportsBasicAuth;
use Illuminate\Contracts\Auth\UserProvider;

class WeChatGuard implements StatefulGuard, SupportsBasicAuth
{
    /**
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    private $user = null;

    protected $userProvider = null;

    /**
     * WeChatGuard constructor.
     * @param UserProvider $userProvider
     */
    public function __construct(UserProvider $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    /**
     * 验证当前是否可用
     * @return bool
     */
    public function check()
    {
        return ! is_null($this->user());
    }

    /**
     * 判断当前用户是否未登录
     * @return bool
     */
    public function guest()
    {
        return !$this->check();
    }

    /**
     * 获取当前已经登陆的用户模块。返回对应的UserModel
     * @return Authenticatable
     */
    public function user()
    {
        $request = Request::capture();
        $this->user = $this->userProvider->retrieveByCredentials([
            'session_key' => str_replace(' ','+',$request->cookie('openid'))
        ]);
        return $this->user;
    }

    /**
     * @return int|null
     */
    public function id()
    {
        return $this->user->id;
    }

    /**
     * 验证用户证书
     * @param array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return false;
    }

    /**
     * 设置User用户模型
     * @param Authenticatable $user
     */
    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * 登陆或者注册
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        // 调用微信接口获取微信用户基础信息
        $wxUser = WeChatUser::getUserInfo();
        // 通过openID判断用户是否已经注册
        $this->user = $this->userProvider->retrieveById($wxUser['openId']);
        // 未注册
        if ($this->user == null ) {
            $this->user = UserModel::create(array_merge(
                [
                    'opendid' => array_get($wxUser,'openId'),
                    'status' => 1,
                    'avatar' => $wxUser['avatarUrl'],
                    'nickname' => $wxUser['nickName']
                ],
                $wxUser
            ));
        }else{

            // 已经注册
            if ($this->user->updated->timestamp < intval(Carbon::now()->startOfWeek()->timestamp)) {
                $this->user->save(['loginTimes' => 0]);
            }else {
                $this->user->increment('loginTimes');
            }
        }
        $this->user->update($wxUser);
        return $wxUser['session_key'];
    }

    public function once(array $credentials = [])
    {
        // TODO: Implement once() method.
    }

    /**
     * 记录登陆用户
     * @param Authenticatable $user
     * @param bool $remember
     */
    public function login(Authenticatable $user, $remember = false)
    {
    }

    public function loginUsingId($id, $remember = false)
    {
        // TODO: Implement loginUsingId() method.
    }

    public function onceUsingId($id)
    {
        // TODO: Implement onceUsingId() method.
    }

    public function viaRemember()
    {
        // TODO: Implement viaRemember() method.
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function basic($field = 'email', $extraConditions = [])
    {
        // TODO: Implement basic() method.
    }

    public function onceBasic($field = 'email', $extraConditions = [])
    {
        // TODO: Implement onceBasic() method.
    }

}