<?php
/**
 * 收益异步计算
 */
namespace App\Jobs;

use App\Traits\JobsFailed;
use Illuminate\Bus\Queueable;
use App\Models\OrderModel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Profit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //use JobsFailed;

    /**
     * @var OrderModel
     */
    protected $model = null;

    /**
     * Create a new job instance.
     *
     * @param OrderModel $model
     * @return void
     */
    public function __construct(OrderModel $model)
    {
        $this->model = $model;
    }

    /**
     * @throws \Exception
     */
    public function handle()
    {
        if ($this->model->status != 2) {
            throw new \Exception("订单状态不满足");
        }

        // 获取子订单信息
        $orders = $this->resolveOrder();
        foreach ($orders as $order){
            app('profit.abstract')->create(
                [
                    'order_id' => $this->model->order_id,
                    'app'   => $this->model->app,
                    'sale'  => bcmul($order['money'], $order['number']),
                    'shared_uid' => $order['shared'],
                    'talent_uid' => $order['talent'],
                    'merchant_id' => $order['merchant_id'],
                    'remark' => $order['remark']
                ]
            );
        }

    }


    /**
     * 检查子订单。主要针对达人，默认当前订单
     * @return array
     */
    protected function resolveOrder()
    {
        if ($this->model->app == 'talent'){
            $appOrder = app('talentOrder.abstract')->findById($this->model->order_id);
            $appPrice = app('talentPrice.abstract')->findById($appOrder['price_id']);
            //$appInfo  = app('talent.abstract')->findById($appPrice['app_id']);
            $appList  = app('talentList.abstract')->findALl([
                ['talent_id',$appPrice['app_id']]
            ],100)['data'];
            $result = [];

            foreach ($appList as $key=>$item){
                $basePrice = app($item['app'].'Price.abstract')->findById($item['price_id']);
                $result[$key] = array_merge(
                    [
                        'number' => $item['number']*$appOrder['number']
                    ],
                    [
                        'money'  => $basePrice['price'],            // 包含活动价
                        'active_id' => $basePrice['active_id'],     // 活动ID
                        'uid'    => $this->model->uid,
                        'talent' => $this->model->talent,
                        'shared' => $this->model->shared,
                        'merchant_id' => $basePrice['merchant_id'],
                        'remark' => $item['app'].'_'.$item['price_id']
                    ]
                );
            }
            smartLog('jobs','profit', $result);
            return $result;
        }else {

            $appOrder = app($this->model->app.'Order.abstract')->findById($this->model->order_id);
            $basePrice = app($this->model->app.'Price.abstract')->findById($appOrder['price_id']);
            return [
                [
                    'number' => $appOrder['number'],
                    'money'  => $basePrice['price'],            // 包含活动价
                    'active_id' => $basePrice['active_id'],     // 活动ID
                    'uid'    => $this->model->uid,
                    'talent' => $this->model->talent,
                    'shared' => $this->model->shared,
                    'merchant_id' => $basePrice['merchant_id'],
                    'remark' => $this->model->app.'_'.$appOrder['price_id']
                ]
            ];
        }
    }
}
