<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImagesServiceProvider extends ServiceProvider
{
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
        $this->app->singleton(
            \App\Contracts\ImageHandleService::class,
            \App\Services\ImageHandleService::class
        );
    }
}
