<?php
/**
 * 直通车支付接口抽象类
 * User: Master King
 * Date: 2019/1/30
 */

namespace App\Api\cd917;
use GuzzleHttp\Client;

abstract class ApiAbstract
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
    private static $httpClient = null;

    /**
     * 请求接口
     * @var null
     */
    private $response = null;

    /**
     * 接口地址
     * @var string
     */
    private $url = 'http://beta.cd917.com/OpenApi/';


    /**
     * 创建唯一的一个http请求器
     * @return Client|null
     */
    private static function httpInstance(){
        if (self::$httpClient == null) {
            self::$httpClient = new Client();
        }
        return self::$httpClient;
    }

    /**
     * @return self
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    final public function Request(): self {
        try {
            $param = array_merge(
                $this->attributes,
                [
                    'sign' => $this->sign(),
                    'apiKey' => self::$apiKey,
                ]
            );
            $this->response = self::httpInstance()->request(
                'POST',
                $this->url.$this->getApiUri(),
                ['form_params'=>$param],
                ['stream' => true]
            );
            return $this;
        }catch (\Exception $exception) {
            self::$httpClient = null;
        }
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
     * 填充数据. 把数据填充到attribute中
     * @param $data
     * @return self
     */
    abstract public function filledAttribute($data) : self ;

    /**
     * 返回请求URI
     * @return string
     */
    abstract protected function getApiUri(): string ;

    /**
     * 数据结果处理
     */
    abstract public function updateOrCreate();

    /**
     * 解析stream数据,得到string
     */
    final protected function getResponse(): string {
        $content = $this->response->getBody(); // stream
        return $content->read($content->getSize());
    }
}