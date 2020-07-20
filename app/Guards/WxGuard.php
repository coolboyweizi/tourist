<?php
/**
 * User: Master King
 * Date: 2018/11/29
 */

namespace App\Guards;

use Illuminate\Auth\SessionGuard;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Iwanli\Wxxcx\Wxxcx;


class WxGuard extends SessionGuard
{
    /**
     * Client Type  number 0 is From WX , number 1 is From User
     *
     * @var
     */
    private $client ;  // 0 是wx  1是user

    /**
     * There are at 2 providers 。
     * You should register them At AuthServiceProvider
     *
     * @var array
     */
    protected $providers = [];

    /**
     * The WeiXin Api
     * @var Wxxcx
     */
    private $wxxcx ;

    /**
     * @var null
     */
    private $wxCode = null;

    /**
     * @var null
     */
    private $openId = null;

    /**
     * 构造器
     * @param $name  App name
     * @param UserProvider $wxUserProvider  微信用户提供器
     * @param UserProvider $userProvider    后台用户提供器
     * @param Session $session              session 管理
     * @param Request $request              Request 对象
     * @param Wxxcx $wxxcx                  微信接口对象
     */
    function __construct(
        $name,
        UserProvider $wxUserProvider,
        UserProvider $userProvider,
        Session $session,
        Request $request ,
        Wxxcx $wxxcx
    )
    {
        $this->providers = [
            0 => $wxUserProvider,
            1 => $userProvider,
        ];

        $this->request = $request;
        $this->wxxcx = $wxxcx;

        parent::__construct(
            $name,
            $this->getClientProvider(),
            $session,
            $request
        );

    }

    /**
     * 构造的时候，判断是微信端还是PC端。并返回对应的用户提供器
     * 因为PC端每次请求带有相关的cookie，微信没有cookie，所以微信登入的时候需要返回一个session_id 给微信端
     *
     * 判断微信与PC端区分是，微信端的cookies有code
     *
     *
     * 0 微信 1 PC端
     * @return mixed
     */
    private function getClientProvider(){
        $cookies =  $this->request->cookies->all();
        if (
           ($this->wxCode = str_replace(' ','+',array_get($cookies,'code', ''))) !==''
            //($this->wxIv = str_replace(' ','+',array_get($cookies,'iv','')) ) !=='' &&
            //($this->openid = str_replace(' ','+',array_get($cookies,'openid','')) ) !=='' &&
            //($this->encryptedData = str_replace(' ','+',array_get($cookies,'encryptedData', '' ))) !==''
        ) {

            $this->client = 0 ;
        } else {
            $this->client = 1 ;
        }

        return $this->providers[$this->client];
    }

    /**
     * 获取微信端的远程接口。在login的时候调用
     * @return array
     * @throws \Exception
     */
    private function getWxApiUser(){

        //根据 code 获取用户 session_key 等信息, 返回用户openid 和 session_key
        $userInfo = $this->wxxcx->getLoginInfo($this->wxCode);
        //$openId = $userInfo['openid'];
        $session_key = $userInfo['session_key'];

        // 微信base user
        $wxBaseUser =  json_decode($this->wxxcx->getUserInfo(
            $this->request->input('encryptedData'),
            $this->request->input('iv')),
            true
        );

        return [
            'opendid' => $wxBaseUser['openId'],
            'avatar' => $wxBaseUser['avatarUrl'],
            'nickname' => $wxBaseUser['nickName'],
            'gender' => $wxBaseUser['gender'],
            'province' => $wxBaseUser['province'],
            'city' => $wxBaseUser['city'],
            'session_key' => $session_key,
        ];
    }

    /**
     * 更新
     * @param array $wxUser
     */
    private function updateModel(array $wxUser) {
        $this->user = $this->provider->updateRememberToken($this->user(), $wxUser);
    }

    /**
     * 注册一个微信用户并登陆。在登入的时候处理
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    private function wxUserLoginOrRegister(){

        try {

            $wxUser = $this->getWxApiUser();

            $this->user = $user = $this->provider->retrieveById(
                $wxUser['opendid']
            );

            if ( ! is_null($user)) {
                $this->updateModel($wxUser);
                return $user;
            }

            if ( $this->provider->create($wxUser) ) {
                $this->user = $user = $this->provider->retrieveById(array_get($wxUser,'opendid'));
            }

            return $user;
        }catch (\Exception $exception) {
            info("WxGuard Error:".$exception->getMessage());
            //var_dump($exception->getMessage());exit;
            return false;
        }
    }

    /**
     * Guard Check For Auth Middleware
     *
     * @return bool
     * @throws \Exception
     */
    public function check()
    {
        if ($this->client == 0 ) {
            // 检查登录
            $this->user = $this->provider->retrieveById($this->request->cookies->get('openid'));

            if (parent::check()) {
                return true;
            }else {
                return false;
            }
        }else {
            if (parent::check()) {
                return true;
            }else {
                return false;
                //return redirect('/login.html');
            }
        }
    }

    /**
     * 微信登入。
     * 1、通过cookie获取User信息
     * @param array $credentials
     * @param bool $remember
     * @return bool
     */
    public function attempt(array $credentials = [], $remember = false)
    {
        if ($this->client == 1) {
            return parent::attempt($credentials, $remember);
        }else {

            $user = $this->getUser();
            if (  empty($user) or strtotime($user->updated ) < time() - 3600 ) {

                $user = $this->wxUserLoginOrRegister();
            }
            $this->login($user, $remember);

           return $user->opendid;
        }

    }

}