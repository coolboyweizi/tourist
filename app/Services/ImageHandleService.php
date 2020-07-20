<?php
/**
 * 图片处理服务
 * User: Master King
 * Date: 2019/1/28
 */

namespace App\Services;
use Illuminate\Support\Facades\Storage;
use App\Contracts\ImageHandleService as Contract;

class ImageHandleService implements  Contract
{
    /**
     * 宽
     * @var int
     */
    private $width = 700;

    /**
     * 高
     * @var int
     */
    private $height= 400;

    /**
     * 图册集
     * @var array
     */
    private $thumbs = [];

    /**
     * K-V结构。 每张图对应的
     * @var array
     */
    private static $rule = [
        1 => 1,
        2 => 1,
        4 => 2,
        9 => 3
    ];

    /**
     * 像素数组
     * @var array
     */
    private $pixel =  [
            'top-left' => [
                'x' => 0,
                'y' => 0,
                'h' => 376,
                'w' => 478,
                'd' => 'https://static.scxysd.com/rtimg2.png'
            ],
            'top-right' => [
                'x' => 0,
                'y' => 0,
                'h' => 200,
                'w' => 200,
                'd' => 'https://static.scxysd.com/rtimg2.png'
            ],
            'bottom-right' => [
                'x' => 0,
                'y' => 0,
                'h' => 200,
                'w' => 200,
                'd' => 'https://static.scxysd.com/rtimg2.png'
            ],
    ];

    /**
     * 图片排列行数
     * @var int
     */
    private $line = 1;

    /**
     * 处理图片
     * @param array $thumbs
     * @return $this
     */
    public function init(array $thumbs){
        $this->thumbs = $thumbs;
        return $this;
    }

    /**
     * 设置基本参数
     * @param array $config
     */
    public function config(array $config){
        foreach ($config as $key=>$val){
            if(property_exists($this, $key)){
                $this->$key = $val;
            }
        }
    }

    /**
     * 获取行数
     * @return mixed
     */
    public function line(){
        /*array_walk(self::$rule, function ($value, $key) use(&$line)  {
            if ($line < 1 && count($this->thumbs) <= $key){
                $line = $value;
            }
            if (count($this->thumbs) > max(array_keys(self::$rule)) ) {
                $line = [max(array_keys(self::$rule))];
            }
        });
        $this->line = $line;*/
        return $this;
    }

    /**
     * 像素分组
     * left: 182 h width: 64
     * right: 90 h width: 35
     * [
     *  'top-left':
     * ]
     *
     *
     *
     * @return $this
     */
    public function pixed()
    {
        return $this;
    }

    /**
     * 图片处理
     * @return string
     */
    public function make():string {
        // 创建空图水影
        $img = \Image::canvas($this->width, $this->height);

        foreach (array_keys($this->pixel) as $key=>$field){

            // 获取默认
            $pic = array_get($this->thumbs,$key, $this->pixel[$field]['d']);

            // 图片裁剪
            $imc = \Image::make($pic)->resize( $this->pixel[$field]['w'],  $this->pixel[$field]['h']);
            $imc->save($field.'.jpg');
            // 图片写入
            $img->insert($imc->encode(),$field,$this->pixel[$field]['x'],$this->pixel[$field]['y']);
        }

        $pic = time().rand(1000,9999).'.jpg';
        Storage::disk('local')->put($pic, $img->encode());
        return $pic;
    }
}