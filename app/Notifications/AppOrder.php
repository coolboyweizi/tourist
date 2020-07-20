<?php
/**
 * 系统订单
 */
namespace App\Notifications;

use App\Channels\DataBase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class AppOrder extends Notification
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
     * 返回通知消息体
     * @param $notifiable
     * @return string
     */
    public function getMsgBody($notifiable){
        return '成功订购价值'.$notifiable->amount.'商品:'.$notifiable->title;
    }

}
