<?php
/**
 * 达人价格异步计算
 */
namespace App\Jobs;

use App\Models\TalentListModel;
use App\Traits\JobsFailed;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class TalentPrice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    use JobsFailed;

    /**
     * 达人ID
     * @var int
     */
    private $talent_id = 0;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($talent_id)
    {
        $this->talent_id = $talent_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 查询达人列表
        $talentList = TalentListModel::where('talent_id',$this->talent_id)->get();

        // 设置默认金额，进行循环计算
        $amount = 0;

        foreach ($talentList as $item){
            $appPrice = app($item->app.'Price.abstract')->findById($item->price_id);
            $amount = bcadd($amount, bcmul($item->number, $appPrice['price'],'2'));
        }

        \App\Models\TalentPriceModel::updateOrCreate([
            'app_id' => $this->talent_id,
        ],[
            'title' => '达人定制:'.app('talent.abstract')->findById($this->talent_id)['title'],
            'unit'  => '套',
            'price' => $amount,
        ]);
    }

}
