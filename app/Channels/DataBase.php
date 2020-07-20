<?php
/**
 * 数据库通知。 notifiable必须要有uid
 * User: Master King
 * Date: 2019/3/11
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;
use App\Models\NotificationModel;

class DataBase
{
    public function send($notifiable, Notification $notification)
    {
        NotificationModel::create([
            'uid' => $notifiable->uid,
            'type' => $notification->app,
            'data' => $notification->getMsgBody($notifiable),
            'read' => 0
        ]);
        // 将通知发送给 $notifiable 实例
    }
}