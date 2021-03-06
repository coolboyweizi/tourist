<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Site;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        //左侧菜单
        view()->composer('admin.layout',function($view){
            $menus = \App\Models\Permission::with([
                'childs'=>function($query){$query->with('icon');}
                ,'icon'])->where('parent_id',0)->orderBy('sort','desc')->get();

            $unreadMessage = \App\Models\Message::where('read',1)->where('accept_uuid',auth()->user()->uuid)->count();
            $view->with('menus',$menus);
            $view->with('unreadMessage',$unreadMessage);
        });

        // 引入网站配置项
        Site::all()->map(function ($conf){
            app('config')->set($conf->key, $conf->value);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
