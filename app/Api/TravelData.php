<?php
/**
 * 直通车数据同步
 * User: Master King
 * Date: 2019/2/19
 */

namespace App\Api;

use App\Models\TravelModel;
use App\Models\TravelPriceModel;
use GuzzleHttp\Client;
class TravelData
{
    /**
     * API KEY
     * @var string
     */
    private static $apiKey = 'A801737B4C0D4FC3B83F4230C3E3DAF9';

    /**
     * MD5签名秘钥
     * @var string
     */
    private static $apiSecret = '2C4E8F1C4C2A4A1F83812AC2F798550A';

    /**
     * 请求接口的数据
     * @var array
     */
    protected $attributes = [];

    /**
     * 请求参数
     * @var \GuzzleHttp\Client|null
     */
    private static $instance = null;

    /**
     * 接口地址
     * @var string
     */
    private $url = 'http://beta.cd917.com/OpenApi/GetCodeProductSchedules';

    /**
     * 分类
     * @var array
     */
    protected $ptype = [
        0 => '门票',
        2 =>  '跟团游',
        4 =>  '直通车'
    ];

    public function __construct(string $date)
    {
        $this->attributes = [
            'productCode' => 2019,
            'date' => $date
        ];
    }

    /**
     * HTTP 实例
     * @return Client|null
     */
    private function getInstance(){
        if (!self::$instance instanceof Client) {
            self::$instance = new Client();
        }
        return self::$instance;
    }

    /**
     * 加密规则
     * @return string
     */
    private function sign(){
        $params = $this->attributes;
        ksort($params);
        return strtoupper(md5(
            str_replace('%3a',':',
                self::$apiSecret.strtolower(http_build_query(
                    $params
                )))
        ));
    }

    /**
     * 执行数据请求
     */
    public function execute(){
        try {
            $param = array_merge(
                $this->attributes,
                [
                    'sign' => $this->sign(),
                    'apiKey' => self::$apiKey,
                ]
            );
            $content = $this->getInstance()->request(
                'POST',
                $this->url,
                ['form_params'=>$param],
                ['stream' => true]
            )->getBody();
            // 采集的数据
            $data = \GuzzleHttp\json_decode($content->read($content->getSize()),true);
            if ($data['ErrorCode'] == 0 ){
                $item = $data['Value'];
                $pattern="/(.*)-(.*).*（(.*)）.*/";

                preg_match($pattern,$item['ProductName'],$matches);

                $travel = TravelModel::updateOrCreate([
                    'title' => $matches[0],
                    'departure' => $matches[1],
                    'destination' => $matches[2],
                    'tagsA' => '标签A',
                    'tagsB' => '标签B',
                        'tagsC' => '标签C',
                ],[
                    'pcode' => $item['ProductCode'],
                    'ptype' => $item['ProductType'],
                    'detail' => $matches[3],
                    'thumbs' => \GuzzleHttp\json_encode([
                        'https://static.scxysd.com/delsssban.png',
                        'https://static.scxysd.com/delsssban.png',
                        'https://static.scxysd.com/delsssban.png'
                    ]),
                    'logo' => 'https://static.scxysd.com/crimg2.png',
                ]);

                // 更新时刻表
                foreach ($item['Schedules'] as $schedule){
                    TravelPriceModel::updateOrCreate([
                        'app_id' => $travel->id,
                        'pcode' => $item['ProductCode'],
                        'type' => array_get($this->ptype,$item['ProductType'],'unknown'),
                        'title' => $item['ProductName'],
                        'status' => 1,
                        'godate' => $schedule['GoDate'] ?:strtotime($this->attributes['date']),
                        'schedule'=>$schedule['Schedule'],
                        'unit' => '座/人'
                    ],[
                        'occupiedseats'=>$schedule['OccupiedSeats'],
                        'price' => $item['AppPrice'],
                        'backdate' => $schedule['BackDate']==null?null:strtotime($schedule['BackDate']),
                        'backSchedule' => $schedule['BackSchedule'],
                        'seats'   =>$schedule['Seats'],
                    ]);
                    echo $item['ProductName'].',价格:'.$item['AppPrice'].' ,时间 '.$schedule['Schedule'];
                }
            }

        }catch (\Exception $exception) {
            self::$instance = null;
            echo $exception->getMessage();
        }
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        echo "已经采集".$this->attributes['date']."数据".PHP_EOL;
    }
}