<?php
/**
 * 价格补充
 * User: Master King
 * Date: 2019/2/21
 */

namespace App\Logic;


use App\Exceptions\AppException;
use App\Models\ActiveModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class Active
{

    /**
     * 查询最低价格.这个价格体系最低价格
     */
    public function findMinPrice($price_id){
        $data = app('AppPriceExt.abstract')->findAll([
            [
                'price_id' => $price_id
            ]
        ],['price'=>'asc']);
        return $data['data'][0]??[];
    }

    /**
     * 添加价格活动检查相关状态
     * @param $data
     * @return array
     * @throws AppException
     */
    public function _before_create($data){
        $app = $data['app'];

        $appPrice = app($app.'Price.abstract')->findById($data['price_id']);

        list($stime, $etime) = explode(' - ',$data['active']);

        $stime = strtotime($stime);
        $etime = strtotime($etime);

        if ( ! $appPrice['status']){
            throw new AppException("该项目下价格不可用");
        }

        if ($stime < 0 or $etime <= $stime) {
            throw new AppException("活动时间范围不合理");
        }

        // 判断week或者date
        try {
            $param = explode(',', $data['date']);
            if (in_array(0, $param)) {
                $data['date'] = \GuzzleHttp\json_encode([]);
            }else {
                $data['date'] = \GuzzleHttp\json_encode($param);
            }
        }catch (\Exception $exception){
            $data['date'] = \GuzzleHttp\json_encode([]);
        }

        try {
            $param = explode(',', $data['week']);

            if (in_array(0, $param)) {
                $data['week'] = \GuzzleHttp\json_encode([]);
            }else {
                $data['week'] = \GuzzleHttp\json_encode($param);
            }

        }catch (\Exception $exception){
            $data['week'] = \GuzzleHttp\json_encode([]);
        }

        return array_merge($data, [
            'stime' => $stime,
            'etime' => $etime,
            'remark'=> trim($data['remark'])??"添加时间：".date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * 单服务列表查询。补充价格信息
     * @param $data
     * @return array
     */
    public function _after_find_all($data){
        $items = $data['data'];
        foreach ($items as $key=>$item){
            $price = app($item['app'].'Price.abstract')->findById($item['price_id']);

            $items[$key] = array_merge($item,[
                'title' => $price['appTitle'].'_'.$price['title'],
                'type'  => $price['type'],
                'appAlias' => $price['appAlias']
            ]);
        }
        return [
            'data' => $items
        ];
    }

    /**
     * 查询某个时间段内有效时间
     * @param $price_id
     * @param $app
     * @param $days
     * @return array
     */
    public function priceDate($price_id,$app, $days)
    {
        $instance = Carbon::create(date('Y'),date('m'),date('d'),0,0,0);
        $collections = ActiveModel::where('price_id',$price_id)
            ->where('app',$app)
            ->where('number','>',0)
            ->where('etime', '>' , $instance->timestamp) // 未结束
            ->where('stime', '<' , $instance->timestamp) // 已经开始
            ->get();

        // 找出符合30天内所有的可用价格
        $date2price = $price2date = [];
        foreach ($collections as $collection){
            // 获取满足价格的时间
            $results = $this->getActiveDay($collection, $days);

            // 日期对应的最小价格
            $datePrice = array_fill_keys($results, $collection->price);

            // 价格对应的日期
            // $priceDate = array_merge([],[$collection->price => $results]);

            // 日期价格的填充
            foreach ($datePrice as $date=>$price){
                $data = $old = array_get($date2price, $date, false); // 活动价格
                if ($old != false) {
                   if ($old['price'] > $price) {
                       $data = ['price'=> $price, 'active_id' =>$collection->id];
                   }
                }else {
                    $data = ['price'=> $price, 'active_id' =>$collection->id];
                }
                $date2price[$date] = $data;
            }
            /*foreach ($priceDate as $price=>$date){
                $old = array_get($price2date, $price,[]);
                $price2date[$price] = array_merge($old, $date);
            }*/
        }
        return [
          //'price2date' => $price2date,
          'date2price' => $date2price,
        ];
    }

    /**
     * 根据价格计算时间，
     * @param ActiveModel $collection
     * @param $days
     * @return array
     */
    private function getActiveDay( ActiveModel $collection, $days)
    {
        $weeks = \GuzzleHttp\json_decode($collection->week);
        $dates = \GuzzleHttp\json_decode($collection->date);
        $instance = Carbon::now();
        $result = [];
        for ($i = 0;$i< $days; $i++){

            // 判断时间是否已经过期
            if ($instance->timestamp > strtotime($collection->etime)) { // 时间已经结束
                break;
            }

            // 如果限制了日期和时间，那么限制计算
            if (count($weeks) > 0 or count($dates) > 0 ){
                // 因为按照0开始算星期天的
                if (in_array($instance->dayOfWeek , $weeks)) {
                    array_push($result,$instance->format('Y-m-d'));
                }

                if (in_array($instance->format('d'), $dates)){
                    array_push($result,$instance->format('Y-m-d'));
                }
            }else {
                array_push($result, $instance->format('Y-m-d'));
            }
            $instance->addDay(1);
        }
        return array_sort($result);
    }

}