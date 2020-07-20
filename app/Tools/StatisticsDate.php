<?php
/**
 * 服务于统计的时间工具类
 * 接受一个时间戳，返回相对于时间节点
 * User: Master King
 * Date: 2019/3/1
 */

namespace App\Tools;


use Carbon\Carbon;

class StatisticsDate
{
    /**
     * 单一对象
     * @var null
     */
    private static $instance = null;

    /**
     * 一个月的周数
     * @var int
     */
    public $weekOfMonth = 4;

    /**
     * @var Carbon
     */
    protected $date = [];

    /**
     * 给定时间范围
     * StatisticsDate constructor.
     * @param $start  Carbon|int
     * @param $end    Carbon|int
     */
    private function __construct($start, $end)
    {
        if (!$start instanceof Carbon) {
            $start = Carbon::createFromTimestamp($start);
        }
        if (!$end instanceof Carbon) {
            $end = Carbon::createFromTimestamp($end);
        }
        $this->date = [$start, $end];
        $tmp = Clone $start;
        $this->weekOfMonth = $tmp->endOfMonth()->weekNumberInMonth;

    }


    /**
     * 获取开始键
     * @return Carbon
     */
    public function getStartDate()
    {
        $instance = $this->date[0];
        return $instance;
    }

    /**
     * 获取结束时间
     * @return Carbon
     */
    public function getEndDate(){
        $instance = $this->date[1];
        return $instance;
    }

    /**
     * 构建一个单一对象
     * @param $start
     * @param $end
     * @return StatisticsDate|null
     */
    public static function make($start, $end)
    {
        if (!self::$instance instanceof StatisticsDate){
             self::$instance = new self($start, $end);
        }
        return self::$instance;
    }

    /**
     * 从结束时间向前偏移时间
     * @param int $num
     * @return Carbon
     */
    public function endSubDay(int $num=7){
        $instance =  $this->date[1];
        return $instance->subDay($num);
    }

    /**
     * 从开始时间向前偏移时间
     * @param int $num
     * @return Carbon
     */
    public function startSubDay(int $num){
        $instance =  $this->date[0];
        return $instance->subDay($num);
    }

    /**
     * 从结束时间向后偏移时间
     * @param int $num
     * @return Carbon
     */
    public function endAddDay(int $num=7){
        $instance =  $this->date[1];
        return $instance->addDay($num);
    }

    /**
     * 从开始时间向红原偏移时间
     * @param int $num
     * @return Carbon
     */
    public function startAddDay(int $num){
        $instance =  $this->date[0];
        return $instance->addDay($num);
    }

    /**
     * 从结束时间向后偏移周
     * @param int $week
     * @return Carbon
     */
    public function endAddWeek(int $week){
        $instance =  $this->date[1];
        return $instance->addWeek($week);
    }

    /**
     * 从开始时间向前偏移周
     * @param int $week
     * @return Carbon
     */
    public function startSubWeek(int $week){
        $instance =  $this->date[0];
        return $instance->subWeek($week);
    }

    /**
     * 从结束时间向前偏移周
     * @param int $week
     * @return Carbon
     */
    public function endSubWeek(int $week){
        $instance =  $this->date[1];
        return $instance->subWeek($week);
    }


    /**
     * 从开始时间向后便宜周
     * @param int $week
     * @return Carbon
     */
    public function startAddWeek(int $week){
        $instance =  $this->date[0];
        return $instance->addWeek($week);
    }


    /**
     * 返回这个月开始时间
     * @return Carbon
     */
    public function month(){
        $instance =  $this->date[0];
        return $instance->firstOfMonth();
    }

    /**
     * 返回近一周开始时间
     */
    public function week(){
        $instance =  $this->date[1];
        return $instance->startOfWeek();
    }

}