<?php
/**
 * 对小程序请求的接口参数验证
 * 验证基本思想。采用key=>value的形式进行验证，即
 *  1、key若存在则value必须不存在。
 *  2、key不存在，那么value必须存在
 *
 * 所有的返回值必须是数组且k=>v
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerifyData
{
    private $auth ;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param $modules
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $modules)
    {
        if (strlen($modules) > 0 ) {
           $this->verify($request,$modules);
        }
        return $next($request);
    }

    /**
     * 字段检查
     * @param Request $request
     * @param $modules
     * @throws \Exception
     */
    private function verify(Request $request, $modules)
    {
        $verifies = config('extension.'.$modules.'.verify',[]);
        $verify = array_get($verifies, $request->method(),[]);

        foreach ($verify as $allow => $deny) {
            $a = $b = false ;
            if (!is_numeric($allow)) {  // 单独验证.

                $a = $request->has($allow);

                if (is_array($deny)) {
                    foreach ($deny as $d){
                        if ($b) break;
                        $b = $request->has($d);
                    }
                }else {
                    $b = $request->has($deny);
                }
            }else {
                if (is_array($deny)) {
                    foreach ($deny as $d){
                        if ($b) break;
                        $b = $request->has($d);
                    }
                }else {
                    $b = $request->has($deny);
                }
            }
            if ($a == $b) throw new \Exception("Request Error From Verify Data");
        }
    }
}
