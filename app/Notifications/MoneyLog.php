<?php

namespace App\Notifications;

use App\Channels\DataBase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class MoneyLog extends Notification
{
    use Queueable;

    public $app ;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param $notifiable
     * @return string
     */
    public function via($notifiable)
    {
        return DataBase::class;
    }

    /**
     * 消息日志通知
     * @param $notifiable
     * @return string
     */
    public function getMsgBody($notifiable)
    {
        switch ($notifiable->app) {
            case 'withdraw':
                $body = $notifiable->remark.':'.abs($notifiable->freeze);
                break;
            default:
                $body = $notifiable->remark.':'.abs($notifiable->freeze);
        }
        return $body;
    }
}
