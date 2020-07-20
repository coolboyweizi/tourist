<?php
/**
 * Job失败后队列侦听
 * User: Master King
 * Date: 2019/3/11
 */

namespace App\Channels;


use App\Notifications\Jobs;

class NotificationJobs
{
    public function send($notifiable, Jobs $notification)
    {
        $jobs = $notifiable;
        \App\Models\NotificationJobs::create([
            'jobs' => class_basename(get_class($jobs)),
            'exception' => $jobs->exception->getMessage()
        ]);

    }
}