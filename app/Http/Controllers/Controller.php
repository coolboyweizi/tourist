<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 过滤且返回查询字段
     * @param string
     * @return array
     */
    protected function builderWhere($app)
    {
        $request = Request::capture(); $return = [];
        if (($query = config('extension.'.$app.'.query')) == null) {
            return $return;
        }


        foreach ($query  as $key => $param) {
            if (count($param) == 0) continue;
            if ( $request->has($param[0]) ){
                array_push(
                    $return,
                    $param
                );
            }
        }
        return $return ;
    }

    /**
     * 指定相关模块中间件
     */
    protected function setMiddleware($app, $method)
    {
        $middleware = config('common.'.$app.'.middleware.'.$method);
        foreach ($middleware ??[] as $middleware) {
            $this->middleware($middleware);
        }
    }

}
