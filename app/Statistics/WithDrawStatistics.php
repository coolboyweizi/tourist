<?php
/**
 * 提现统计
 * User: Master King
 * Date: 2019/3/6
 */

namespace App\Statistics;

use App\Tools\StatisticsDate;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WithDrawStatistics
{
    private $date = null;

    private $collections = null;

    public function __construct(StatisticsDate $date)
    {
        $this->date = $date;

        $this->collections = DB::table('withdraw')
            ->where('created','>=', $this->date->getStartDate()->timestamp)
            ->where('created','<=', $this->date->getEndDate()->timestamp)
            ->get();
    }

    /**
     * 处理中
     * @return Collection
     */
    public function dealing(){
        return $this->collections->filter(function ($collection){
            return $collection->status == 0;
        });
    }

    /**
     * 已经处理
     * @return Collection
     */
    public function success(){
        return $this->collections->filter(function ($collection){
            return $collection->status > 0;
        });
    }

    /**
     * 未通过
     * @return Collection
     */
    public function failed(){
        return $this->collections->filter(function ($collection){
            return $collection->status < 0;
        });
    }
}