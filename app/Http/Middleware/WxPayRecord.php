<?php

/**
 * 微信回调数据监控
 */
namespace App\Http\Middleware;

use Closure;
use App\Models\WxPayRecordModel as Model;

class WxPayRecord
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = app('user.abstract')->findAll(['opendid', $request->input('openid')],1);
        $user = $user['total'] == 1? $user[0]['nickname'] : $request->input('openid');
        Model::create(
            array_merge(
                [
                    'nickname' => $user,
                    'status' => 0
                ],
                $request->except('s')
            )
        );
        return $next($request);
    }
}
