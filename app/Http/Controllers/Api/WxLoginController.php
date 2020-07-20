<?php
/**
 * User: Master King
 * Date: 2018/12/2
 * Desc: 微信自动登陆模块。
 *
 *      1、在控制器中获取openid和session_key，session_key可以当成密码使用。如果session_key不对则更新
 *      2、重写$this->validateLogin($request);方法
 *
 *
 */

namespace App\Http\Controllers\Api;


use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class WxLoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }

    public function memberInfo(){
        $user = Auth::user();
        return [
            'code' => 0,
            'data' => [
                'avatar' => $user->avatar,
                'nickName' => $user->nickname,
                'amount' => $user->amount,
                'freeze' => $user->freeze,
                'openid' => $user->opendid,
                'uid' => $user->id,
                'talent' => $user->talent
            ]
        ];
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function login(Request $request)
    {
//        if ( $this->attemptLogin($request) ) {
//            $request->session()->regenerate();
//           return
//        }

        return $this->attemptLogin($request);
    }

    /**
     *守护器验证登陆。 守护器： WxGuard
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($request->except('s'),
            false
        );
    }

    protected function guard()
    {
        return \Illuminate\Support\Facades\Auth::guard('WxAuth');
    }

}