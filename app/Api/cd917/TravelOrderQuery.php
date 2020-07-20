<?php
/**
 * 直通车下单前查询
 * User: Master King
 * Date: 2019/2/19
 */

namespace App\Api\cd917;


class TravelOrderQuery extends ApiAbstract
{
    protected $fields = ['productCode','date','schedule','quantity'];

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

    protected function getApiUri(): string
    {
        return 'BusTicketOrderQuery';
    }

    /**
     * 下单前是否可用。
     * @return array
     * @throws \Exception
     */
    public function updateOrCreate()
    {
        $data = $this->getResponse();
        $result = \Qiniu\json_decode($data, true);
        if (!$result['Success']) {
            throw new \Exception($result['Message']);
        }
        return [
          'success' => $result['Success'],      // true:可以下单，false:不可以下单
          'message' => $result['Message'],      // 失败时为不能下单的原因，成功时为null
        ];
    }

}