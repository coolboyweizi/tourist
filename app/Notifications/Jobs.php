<?php
/**
 * 队列任务异常code代码
 */
namespace App\Notifications;

use App\Channels\NotificationJobs;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class Jobs extends Notification
{
    use Queueable;

    /**
     * @var ShouldQueue
     */
    private $notifiable = null;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param ShouldQueue $notifiable
     * @return string
     */
    public function via(ShouldQueue $notifiable)
    {
        $this->notifiable = $notifiable;
        return NotificationJobs::class;
    }

    /**
     * 获取数据
     */
    public function toVoice(){
        return $this->notifiable;
    }
}
