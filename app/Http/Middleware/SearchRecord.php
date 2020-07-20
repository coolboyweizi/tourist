<?php
/**
 * 搜索记录
 */
namespace App\Http\Middleware;

use Closure;

class SearchRecord
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

        // 优先travel直通车搜索
        if($request->input('app') == 'travel') {
            $keyWords = join('-',[$request->input('departure'),$request->input('destination')]);
        }else {
            $keyWords = $request->input('keywords');
        }

        // 处理搜索逻辑
        \App\Jobs\SearchRecord::dispatch([
            'app' => $request->input('app'),
            'keywords' => $keyWords
        ]);
        return $next($request);
    }
}
