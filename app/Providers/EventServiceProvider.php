<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],

        'App\Events\AppOrderEvent' => [
            'App\Listeners\AppOrder'
        ],

        'App\Events\SysOrderEvent' => [
            'App\Listeners\SysOrder'
        ],

        'App\Events\MerchantMoneyLogEvent' => [
            'App\Listeners\MerchantMoneyLog'
        ],

        'App\Events\MoneyLogEvent' => [
            'App\Listeners\MoneyLogListener',               // 用户资金变日志响应用户的财额度
        ],


    ];

    /**sudo
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
