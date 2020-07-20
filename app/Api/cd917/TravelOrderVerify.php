<?php
/**
 * 直通车订单状态查询
 * User: Master King
 * Date: 2019/1/30
 */

namespace App\Api\cd917;


class TravelOrderVerify extends ApiAbstract
{
    /**
     * 要求字段
     * @var array
     */
    protected $fields = ['number'];

    /**
     * 订单状态码
     * @var array
     */
    protected $orderStatus = [
        12 => 0,            // 代付款
        13 => -2,           // 订单取消
        3 => -2,            // 退款处理中
        4 => -2,            // 退款成功
        7 => 1,             // 已付款
        8 => 2 ,            // 已完成 //订单消费完成
    ];


    /**
     * 填充的字段
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
                throw new \Exception($field.": params error");
            }
        }
        return $this;
    }

    /**
     * 接口URI地址
     * @return string
     */
    protected function getApiUri(): string
    {
        return 'GetOrderStatus';
    }

    public function updateOrCreate()
    {
        $data = $this->getResponse();
        $result = \Qiniu\json_decode($data, true);
        if (array_get($result,'Success', false) === false ){
            throw new \Exception("请求失败:".$result['Message']);
        }
        $values = $result['Value'];
        return [
          'status' => $this->orderStatus[$values['Status']]
        ];
    }

}