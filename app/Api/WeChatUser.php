<?php
/**
 * 微信小程序入口
 * User: Master King
 * Date: 2019/1/15
 */

namespace App\Api;


use EasyWeChat\Factory;
use Illuminate\Http\Request;

class WeChatUser
{
    /**
     * 获取用户
     * @return array
     * @throws \EasyWeChat\Kernel\Exceptions\DecryptException
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public static function getUserInfo(){
        $request = Request::capture();
        $iv = $request->input('iv');
        $encryptData = $request->input('encryptedData');
        $config = config('wechat.mini_program.default');
        $mini = Factory::miniProgram($config);
        $session_key = $mini->auth->session($request->cookie('code'))['session_key'];
        return  array_merge(
            ['session_key' => $session_key],
            $mini->encryptor->decryptData($session_key, $iv, $encryptData)
        );
    }
}