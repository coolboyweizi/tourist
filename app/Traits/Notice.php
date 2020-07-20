<?php
/**
 * User: Master King
 * Date: 2018/11/20
 * 1、判断Notification的实例。
 * 2、判断Channel的实例
 */

namespace App\Traits;

use Illuminate\Notifications\Notifiable;

trait Notice
{
    use Notifiable;

    public function notice(){
        $this->notify(
            new $this->notification($this->app)
        );
    }
}