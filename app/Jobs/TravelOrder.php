<?php
/**
 * 订单处理。即添加数据后，进行队列下单
 */
namespace App\Jobs;

use App\Api\cd917\TravelOrderQuery;
use App\Api\TravelData;
use App\Notifications\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


use Illuminate\Support\Facades\Notification;

class TravelOrder implements ShouldQueue
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
     * 来自于TravelOrder的数据
     * @var array
     */
    private $data = [];

    /**
     * Create a new job instance.
     * @param array $data 数据添加后记录
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * 处理队列
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        // 订单前询问
        (new TravelOrderQuery())->filledAttribute([
            'productCode' => array_get($this->data,'pcode'),
            'date'  => $this->data['godate'],
            'schedule' => array_get($this->data,'schedule'),
            'quantity' => array_get($this->data,'number'),
        ])->Request()->updateOrCreate();

        // 远程下单
        $instance = new \App\Api\cd917\TravelOrderBook();
        $orderNumber = date('YmdHis').rand(100,999);
        $resp = $instance->filledAttribute([
            'productCode' => array_get($this->data,'pcode'),
            'date'  => $this->data['godate'],  // 出行日期
            'schedule' => array_get($this->data,'schedule'),
            'quantity' => array_get($this->data,'number'),
            'tel'   => array_get($this->data,'tel'),
            'number' => $orderNumber
        ])->Request()->updateOrCreate();

        app('travelOrder.abstract')->update([
            $this->data['id']
        ],[
            'apiShortUrl' => $resp['ShortUrl'],
            'apiOrder'=> $resp['Value'],
            'apiTag'=> $resp['Tag'],
            'apiNumber' => $orderNumber
        ]);

        // 启动订单验证的侦听
        TravelOrderVerify::dispatch($this->data['id']);

        // 同步数据
        (new TravelData($this->data['godate']))->execute();
        unset($instance);
    }


}
