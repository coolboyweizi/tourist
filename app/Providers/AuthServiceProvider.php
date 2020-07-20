<?php

namespace App\Providers;

use App\UserProvider\WxApiUserProvider;
use App;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;
use Iwanli\Wxxcx\Wxxcx;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // 扩增一个新的用户守护器
        Auth::extend('WxApi', function ($app, $name, array $config) {
            // 返回一个 Illuminate\Contracts\Auth\Guard 实例...
            return new App\Guards\WeChatGuard(
                Auth::createUserProvider($config['provider'])
            );
        });

        // 扩增一个新的用户提供器
        Auth::provider('WxApi', function ($app, array $config) {
            // 返回 Illuminate\Contracts\Auth\UserProvider 实例...
            return new WxApiUserProvider(
                //$config['model']
            );
        });
    }
}
