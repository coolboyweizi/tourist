<?php
/**
 * 项目统计
 * User: Master King
 * Date: 2019/3/6
 */

namespace App\Statistics;
use App\Tools\StatisticsDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderStatistics
{
    /**
     * 时间对象
     * @var StatisticsDate|null
     */
    private $date = null;

    /**
     * 数据集合
     * @var Collection
     */
    private $collections = null;

    /**
     *
     * ProfitStatistics constructor.
     * @param StatisticsDate $date
     */
    public function __construct(StatisticsDate $date)
    {
        $this->date = $date;
        $this->collections = DB::table('orders')
            ->where('created','>=', $this->date->getStartDate()->timestamp)
            ->where('updated','<=', $this->date->getEndDate()->timestamp)
            ->get();
    }

    /**
     * 未支付订单
     * @return Collection
     */
    public function new(){
        return $this->collections->filter(function ($collection){
            return $collection->status == 0 &&  $collection->created > $this->date->getEndDate()->timestamp;
        });
    }

    /**
     * 有效订单
     */
    public function payed(){
        return $this->collections->filter(function ($collection){
            return $collection->status > 0 &&  $collection->created > $this->date->getEndDate()->timestamp;
        });
    }

    /**
     * 失效订单
     */
    public function missed(){
        return $this->collections->filter(function ($collection){
            return $collection->status == -1 &&  $collection->created > $this->date->getEndDate()->timestamp;
        });
    }
}