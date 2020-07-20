<?php
/**
 * 直通车下单
 * User: Master King
 * Date: 2019/1/30
 */

namespace App\Api\cd917;


class TravelOrderBook extends ApiAbstract
{
    /**
     * 请求接口字段检查
     * @var array
     */
    protected $fields = [
        'productCode',
        'date',         // 出行日志
        'schedule',     // 时刻表
        'quantity',     // 数量
        'tel',          // 电话
    ];

    /**
     * 请求参数检查
     * @param $data
     * @return ApiAbstract
     * @throws \Exception
     */
    public function filledAttribute($data): ApiAbstract
    {
        foreach ($this->fields as $field) {
            if (($value = array_get($data, $field, null)) !== null) {
                $this->attributes = array_merge(
                    $this->attributes,
                    [$field=>$value]
                );
            }else {
                throw new \Exception($field." params error");
            }
        }
        return $this;
    }

    /**
     * 请求URI
     * @return string
     */
    protected function getApiUri(): string
    {
        return 'BusTicketOrderV2';
    }

    /**
     * 请求接口处理
     * @return mixed
     * @throws \Exception
     */
    public function updateOrCreate()
    {
        $data = $this->getResponse();
        $result = \Qiniu\json_decode($data, true);
        if (array_get($result,'Success', false) === false ){
            throw new \Exception("请求失败,".$result['Message']);
        }
        return $result;
    }

}