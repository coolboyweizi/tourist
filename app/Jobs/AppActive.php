<?php
/**
 * 商品活动队列。
 */
namespace App\Jobs;

use App\Models\ActiveModel;
use App\Models\OrderModel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AppActive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 数据
     * @var array|null
     */
    private $data = null;

    /**
     * Create a new job instance.
     *
     * @param array $order
     * @return void
     */
    public function __construct(array $order)
    {
        $this->data = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 查询活动ID。判断number，金额，
        $active = ActiveModel::find($this->data['active_id']);
        $order  = OrderModel::find($this->data['id']);

        if ($active->number < 1 ){
            $order->update(['status'=> -2],['remark'=>'活动已经结束']);
        }elseif ($order->status == 0){
            $active->decrement('number');
            $order->update(['status' => 1]);
        }
    }
}
