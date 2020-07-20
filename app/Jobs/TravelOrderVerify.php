<?php
/**
 * 直通车订单利用延时特性,进行订单验证
 */
namespace App\Jobs;

use App\Notifications\Jobs;
use App\Traits\JobsFailed;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;


class TravelOrderVerify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    public $exception = null;

    /**
     * @param  $exception
     */
    public function failed($exception)
    {
        $this->exception = $exception;
        Notification::send($this, new Jobs());
    }
    /**
     * 直通车ID
     * @var int
     */
    private $talent_order_id = 0;

    /**
     * Create a new job instance.
     *
     * @param int $talent_order_id
     * @return void
     */
    public function __construct(int $talent_order_id)
    {
        $this->talent_order_id = $talent_order_id;
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        // 获取基础数据
        $data = app('travelOrder.abstract')->findById($this->talent_order_id);

        // 查询订单验证
        $instance = new \App\Api\cd917\TravelOrderVerify();
        $resp = $instance->filledAttribute([
            'number' => $data['apiOrder'],
        ])->Request()->updateOrCreate();

        // 如果待支付
        if ($resp['status'] == 0) { // 远程订单待支付中
            echo "直通车订单确认支付中".PHP_EOL;
            if ($data['status'] == 1) {
                app('travelOrder.abstract')->update([$this->talent_order_id],[
                    'status' => 0,
                ]);
            }
            // 1分钟后重新检查支付状态
            echo "1分钟后重新检查".PHP_EOL;
            self::dispatch($this->talent_order_id)->delay(Carbon::now()->addMinute(1));
        }

        // 已支付
        if ($resp['status'] == 1) { // 已经支付
            echo "直通车接口已经支付".PHP_EOL;
            if ($data['status'] == 0) {
                app('travelOrder.abstract')->update([$this->talent_order_id], [
                    'status' => 1,
                ]);

                // 定时请求发起远程订单确认
                echo "直通车接口已经支付，添加队列延迟验证" . PHP_EOL;
                self::dispatch($this->talent_order_id)->delay(Carbon::createFromTimestamp(
                    strtotime($data['godate'] . ' ' . $data['schedule'])
                )->subHour(1));
            }
        }

        if ($resp['status'] == 2) { // 已经使用
            echo "直通车接口已经使用".PHP_EOL;

            if ($data['status'] == 0) {
                app('travelOrder.abstract')->update([$this->talent_order_id],[
                    'status' => 2,
                ]);
            }
        }

    }
}
