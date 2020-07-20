<?php
/**
 * User: Master King
 * Date: 2019/3/11
 */

namespace App\Traits;

use Exception;
use App\Notifications\Jobs;
use Illuminate\Support\Facades\Notification;

trait JobsFailed
{
    /**
     * @var Exception
     */
    public $exception = null;

    /**
     * @param Exception $exception
     */
    public function failed(Exception $exception)
    {
        $this->exception = $exception;
        smartLog('debug','jobs',$exception->getTraceAsString());
        Notification::send($this, new Jobs());
    }
}