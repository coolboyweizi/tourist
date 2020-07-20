<?php
/**
 * 流量统计
 * User: Master King
 * Date: 2019/3/1
 * Usage:
 *
 */

namespace App\Statistics;


use App\Tools\StatisticsDate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Nexmo\Call\Collection;

class PvStatistics
{
    private $date = null;

    private $collections = null;

    public function __construct(StatisticsDate $date)
    {
        $this->date = $date;

        $this->collections = DB::table('daily_pv')
            ->where('created','>=', $this->date->getStartDate()->timestamp)
            ->where('created','<=', $this->date->getEndDate()->timestamp)
            ->get();
    }

    /**
     * 年流量
     * @return Collection
     */
    public function year(){

    }

    /**
     * 月流量
     * @param int $month
     * @return Collection
     */
    public function month(int $month )
    {
        $collections = $this->collections;
        $date = $this->date;

        $collections = $collections->groupBy(function ($item, $key){
            return Carbon::createFromTimestamp(strtotime($item->dated))->month;
        })->get($month,function () use($date, $month) {
            $instance = $date->getStartDate()->month($month);
            $days = $date->getStartDate()->month($month)->daysInMonth;
            $arr = [];
            for ($i = 1; $i<= $days; $i++){
                $arr = array_merge(
                    $arr,
                    [
                        $instance->format('y-m-d') => [
                            'count' => 0,
                        ]
                    ]
                );
                $instance->addDay();
            }
            return collect($arr);
        });

        var_dump($collections);
        return $collections;


    }

    /**
     * 周流量
     * @param int $week 如果为0 返回所有
     * @return Collection
     */
    public function week($week = 0){

        $week = $week  > $this->date->weekOfMonth ?
                $this->date->weekOfMonth:
                $week;

        $collections = $this->collections;

        $collections = $collections->groupBy(function ($item, $key){
            return Carbon::createFromTimestamp(strtotime($item->dated))->weekNumberInMonth;
        });

        for ($i=1; $i<=$this->date->weekOfMonth; $i++)
        {
            $collection = $collections->get($i,0);
            if ($collection !== 0) {
                $collections[$i] = $collection->sum('count');
            }else {
                $collections[$i] = 0;
            }
        }
        return $week == 0 ?
            $collections->sortByDesc(function ($item, $key){return $key;}) :
            $collections->get($week);
    }

    /**
     * 返回某日流量
     * @return Collection
     */
    public function day(string $date){
      $items = $this->collections;
      $items = array_get($items->groupBy('dated'),$date,collect([]))->sortBy('times')->groupBy('times');

      for ($i = 0; $i < 24; $i++){
          $schedule = $i<10? '0'.$i:$i;
          $collection = $items->get($schedule,collect(['count'=>0]));
          unset($items[$schedule]);
          $items[$schedule.':00'] = $collection->sum('count');
      }
        return $items->sortBy(function ($item,$key){
          return $key;
      });
    }

    /**
     * 返回比例
     * @param PvStatistics $pvStatistics 制定一个对象进行对比
     * @param String $type 对比类型
     * @return float
     */
    public function rate(PvStatistics $pvStatistics, $type = 'month')
    {

        return bcdiv(
                    call_user_func_array([$pvStatistics, $type],[])->count(),
                    call_user_func_array([$this,$type],[])->count(),
                    2
        );
    }
}