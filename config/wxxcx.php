<?php

return [
	/**
	 * 小程序APPID
	 */
    'appid' => 'wxbbb34fceedb03bc0',
    /**
     * 小程序Secret
     */
    'secret' => 'f477ddb218c1cbe79f484a824123982f',
    /**
     * 小程序登录凭证 code 获取 session_key 和 openid 地址，不需要改动
     */
    'code2session_url' => "https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
];
