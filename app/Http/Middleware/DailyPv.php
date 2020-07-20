<?php
/**
 * PV监控
 */
namespace App\Http\Middleware;

use App\Jobs\Flux;
use App\Models\DailyPvModel;
use Closure;

class DailyPv
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
        Flux::dispatch();
        //ProcessPodcast::dispatch();
        return $next($request);
    }
}
