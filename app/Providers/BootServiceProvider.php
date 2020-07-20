<?php
/**
 * 实现BootService批量启动
 */
namespace App\Providers;

use App\Services\BootService;
use Illuminate\Support\ServiceProvider;

class BootServiceProvider extends ServiceProvider
{
    /**
     * 默认启动服务
     * @var string
     */
    private $defaultBootService = BootService::class;

    /**
     * 装载的配置文件
     * @var string
     */
    private $config = 'extension';

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        foreach (config($this->config) as $bootApp=> $bootAppConfig)
        {
            $binds = array_get($bootAppConfig,'service', []);
            $abstract = array_get($binds,'abstract',$bootApp.'.abstract');
            $concrete = array_get($binds,'concrete', $this->defaultBootService );

            // 创建实例
            $this->app->singleton(
                $abstract, // favorite.abstract
                $concrete  // BootService
            );
            $instance = $this->app->make($abstract);

            $instance->setModel( array_get($bootAppConfig,'model',null));
            $instance->setClosure( array_get($bootAppConfig,'closure',null));
            $instance->setExceptionCode( array_get($bootAppConfig,'errorCode',0));
        }
    }
}
