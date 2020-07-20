<?php
/**
 * 用户统计计算
 * User: Master King
 * Date: 2019/3/1
 */

namespace App\Statistics;


use App\Tools\StatisticsDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserCalc
{
    /**
     * 时间对象
     * @var StatisticsDate
     */
    private $date = null;

    /**
     * 检索的数据集合
     * @var Collection
     */
    private $collections = null;

    /**
     * UserCalc constructor.
     * @param StatisticsDate $date
     */
    public function __construct(StatisticsDate $date)
    {
        $this->date = $date;

        $this->collections = DB::table('users')
            ->where('updated', '>=', $this->date->getStartDate()->timestamp)
            ->where('updated','<=', $this->date->getEndDate()->timestamp)
            ->get();
    }

    /**
     * 活跃度，默认按周计算
     * @param int $page 页码
     * @param int $limit 数量
     * @return Collection
     */
    public function live($page =1, $limit = 10)
    {
        return $this->collections->filter(function ($collection){
            return $collection->loginTimes > 0 && $collection->updated > $this->date->getEndDate()->startOfWeek()->timestamp;
        })->sortByDesc(function ($collection){
            return $collection->loginTimes;
        })->forPage($page,$limit);
    }

    /**
     * 返回这个时间月注册。
     * @return Collection
     */
    public function monthReg()
    {
        $items = $this->collections;
        $date = $this->date->getStartDate();
        return $items->filter(function ($value, $key) use($date) {
            return $value->created > $date->timestamp;
        });
    }

    /**
     * 返回最近一周注册量。
     * @return Collection
     */
    public function weekReg()
    {
        $items = $this->collections;
        $date = $this->date->getEndDate();
        return $items->filter(function ($value, $key) use($date) {
            return $value->created > 0;
        })->groupBy(function ($collection){
            return Carbon::createFromTimestamp($collection->created)->format('y-m-d');
        })->map(function ($items){
            return $items->count();
        });
    }


    /**
     * 返回数据集合中，某一周登陆的用户.
     * @return Collection
     */
    public function weekLive($week = 1)
    {
        if ($week < 1) {
            $week = 1;
        }
        if ($week > $this->date->weekOfMonth){
            $week = $this->date->weekOfMonth;
        }

        $instance = $this->date->startAddWeek($week-1);
        $collections = $this->collections;

        return $collections->filter(function ($collection, $key) use($instance) {
            return  $collection->updated > $instance->startOfWeek()->timestamp &&
                    $collection->updated < $instance->endOfWeek()->timestamp;
        });
    }
}