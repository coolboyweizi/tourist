<?php
/**
 * 直通车价格时刻表
 * User: Master King
 * Date: 2019/1/30
 */

namespace App\Api\cd917;

use App\Models\TravelModel;
use App\Models\TravelPriceModel as Model;
use Carbon\Carbon;

class TravelPrice extends ApiAbstract
{
    /**
     * 请求必要参数
     * @var array
     */
    private $fields = [
        'date',
        'productCode'
    ];

    /**
     * 分类
     * @var array
     */
    protected $ptype = [
        0 => '门票',
        2 =>  '跟团游',
        4 =>  '直通车'
    ];

    /**
     * 填充数据请求接口
     * @param $data
     * @return apiAbstract
     * @throws \Exception
     */
    public function filledAttribute($data): apiAbstract
    {
        foreach ( $this->fields as $field) {
            if ( ($value = array_get($data,$field, false)) !== false) {
                $this->attributes = array_merge(
                    $this->attributes,
                    [$field=>$value]
                );
            }else {
                throw new \Exception("字段：${field} 不存在");
            }
        }
        return $this;
    }

    /**
     * 请求的URI
     * @return string
     */
    protected function getApiUri(): string
    {
        return 'GetCodeProductSchedules';
    }

    /**
     * 更新数据
     * @return mixed
     * @throws \Exception
     */
    public function updateOrCreate()
    {
        $data = $this->getResponse();
        $result = json_decode($data, true);
        if (array_get($result,'Success', false) === false ){
            //throw new \Exception(array_get($result,'Message'));
            // 失效
            return array_get($result,'Message'); //
        }
        $items = $result['Value'];
        $schedules = $items['Schedules'];
        $response = [];
        foreach($schedules as $schedule) {
            $model = Model::firstOrCreate([
                'app_id' => TravelModel::where('pcode',$items['ProductCode'])->first()->id,
                'pcode' => $items['ProductCode'],
                'type' => array_get($this->ptype,$items['ProductType'],'unknown'),
                'title' => $items['ProductName'],
                'price' => $items['AppPrice'],
                'status' => 1,
                'godate' => $schedule['GoDate'] ?:strtotime($this->attributes['date']),
                'backdate' => $schedule['BackDate']==null?null:strtotime($schedule['BackDate']),
                'schedule'=>$schedule['Schedule'],
                'backSchedule' => $schedule['BackSchedule'],
                'seats'   =>$schedule['Seats'],
                'occupiedseats'=>$schedule['OccupiedSeats'],
                'unit' => '座/人'
            ]);
            $response[] = $model->save()?$model->getKey():'失败';
        }
        return $response;
    }

}