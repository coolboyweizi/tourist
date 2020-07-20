<?php
/**
 * 热门商品
 */
namespace App\Http\Middleware;

use App\Models\HotAppModel;
use Closure;

class HotApp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        $url = explode('/',$request->get('s'));
        HotAppModel::firstOrCreate(
            [
                'times' =>date('ymd'),
                'app'   =>$type,
                'app_id' =>  $url[count($url)-1],  // project/id  hotel/id
            ])->increment('count',1);
        return $next($request);
    }
}
