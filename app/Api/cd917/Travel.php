<?php
/**
 * 直通车信息采集
 * User: Master King
 * Date: 2019/1/30
 */

namespace App\Api\cd917;

use App\Models\TravelModel as Model;

class Travel extends ApiAbstract
{
    /**
     * 请求必须要参数
     * @var array
     */
    private $fields = [
        'pageIndex',
        'pageSize'
    ];

    /**
     * 请求参数检查
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
                throw new \Exception("参数: ${field} 不存在");
            }
        }
        $this->attributes = array_merge(
            $this->attributes,
            ['productCode' => '']
        );
        return $this;
    }

    /**
     * 请求接口URI
     * @return string
     */
    protected function getApiUri(): string
    {
        return 'GetCodeProductList';
    }


    public function updateOrCreate()
    {
        $data = $this->getResponse();
        $result = \Qiniu\json_decode($data, true);
        if (array_get($result,'Success', false) === false ){
            throw new \Exception("请求失败");
        }
        $values = $result['Value'];

        $response = [];
        foreach ($values as $value) {
            $patt="/(.*)-(.*).*（(.*)）.*/";

            preg_match($patt,$value['ProductName'],$matches);

            $travel = Model::updateOrCreate([
                'title' => $matches[0],
                'departure' => $matches[1],
                'destination' => $matches[2],
                'tagsA' => '标签A',
                'tagsB' => '标签B',
                'tagsC' => '标签C',
            ],[
                'pcode' => $value['ProductCode'],
                'ptype' => $value['ProductType'],
                'detail' => $matches[3],
                'thumbs' => \GuzzleHttp\json_encode([
                    'https://static.scxysd.com/delsssban.png',
                    'https://static.scxysd.com/delsssban.png',
                    'https://static.scxysd.com/delsssban.png'
                ]),
                'logo' => 'https://static.scxysd.com/crimg2.png',
            ]);
            $response[] = $travel->save()? $value['ProductCode']:'';
        }
        return $response;
    }

}