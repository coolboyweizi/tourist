<?php

namespace App\Console\Commands;

use App\Models\TalentListModel;
use App\Models\TalentModel;
use Illuminate\Console\Command;

class Talent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'talent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '达人价格每日同步';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $talent = TalentModel::where('status',1)->get();
        foreach ($talent as $item){
            echo "计算:".$item->title.PHP_EOL;
            $this->calc($item->id);
        }
    }
    private function calc($talent_id){
        // 查询达人列表
        $talentList = TalentListModel::where('talent_id',$talent_id)->get();

        // 设置默认金额，进行循环计算
        $amount = 0;

        foreach ($talentList as $item){
            try {
                $appPrice = app($item->app.'Price.abstract')->findById($item->price_id);
            }catch (\Exception $exception){
                $appPrice['price'] = 0;
                TalentListModel::destroy($item->id);
            }
            $amount = bcadd($amount, bcmul($item->number, $appPrice['price'],'2'));
        }

        \App\Models\TalentPriceModel::updateOrCreate([
            'app_id' => $talent_id,
        ],[
            'title' => '达人定制:'.app('talent.abstract')->findById($talent_id)['title'],
            'unit'  => '套',
            'price' => $amount,
        ]);
    }
}
