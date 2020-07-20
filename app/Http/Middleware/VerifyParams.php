<?php

namespace App\Http\Middleware;

use Closure;

class VerifyParams
{
    /**
     * 验证微信端请求参数的合理性
     * 1、每队数组字段或值必须有其中一个存在
     * 2、
     * @param $request
     * @param Closure $next
     * @param $modules
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next, $modules)
    {
        // 获取方法
        $method = $request->method();

        $params = config('comment.'.$modules.'.wxParams.'.$method);

        foreach ($params as $allow => $deny) {
            // 如果deny为空，allow必须存在
            if (count($deny) == 0 && !$request->has($allow) ) {
                throw new \Exception("参数${allow}不存在");
            }
            // 如果deny不为空且字段不存在，则要求deny
            else if (count($deny) && !$request->has($allow)) {
                foreach ($deny as $val) {
                    if (!$request->has($val)) throw new \Exception("参数${val}不存在");
                }
            }
            // 如果deny不为空且字段存在，则拒绝deny
            else if (count($deny) && $request->has($allow)) {
                foreach ($deny as $val) {
                    if ($request->has($val)) throw new \Exception("参数${val}存在");
                }
            }
        }
        return $next($request);
    }
}
