<?php
/**
 * 项目的业务服务
 * User: Master King
 * Date: 2019/1/10
 */

namespace App\Logic;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppLogic
{
    private $app = null;

    private static $starImg = [
        '0.0'   => 'scimgon0.png',
        '0.5'   => 'scimgon0.5.png',
        '1.0'   => 'scimgon1.png',
        '1.5'   => 'scimgon1.5.png',
        '2.0'   => 'scimgon2.png',
        '2.5'   => 'scimgon2.5.png',
        '3.0'   => 'scimgon3.png',
        '3.5'   => 'scimgon3.5.png',
        '4.0'   => 'scimgon4.png',
        '4.5'   => 'scimgon4.5.png',
        '5.0'   => 'scimgon5.png',
    ];

    static $demo = 0;

    /**
     * 创建的时候需要制定APP类型
     * AppService constructor.
     * @param $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * 查询单个数据后置操作
     * @param $data
     * @return array
     */
    public function _after_find($data)
    {

        return array_merge(
            $data,
            $this->moreData($data)
        );
    }

    /**
     * 列表查询
     * @param $pageList
     * @return array
     */
    public function _after_find_all($pageList){
        $items = $pageList['data'];
        foreach ($items as $key => $val) {
            $val = (array) $val;
            $items[$key] = array_merge(
                $val,
                $this->moreData($val)
            );
            if($val['status']==0){
                DB::table($this->app.'_price')->where(['app_id'=>$val['id']])->update(['status' => 0]);
            }
        }
        return [
            'data'=>$items
        ];
    }

    /**
     * 填充额外数据
     * @param $data
     * @return array
     */
    public function moreData($data)
    {
        $fa = DB::table('favorite')
            ->where('uid', Auth::id()?:0)
            ->where('app_id',array_get($data,'id'))
            ->where('app', $this->app)->first();

        // 评论的平均分
        $avg = DB::table('comment')
            ->where([
                'app' => $this->app,
                'app_id' => array_get($data,'id'),
                'status' =>1
            ])->avg('stars')?:0;
        // 最低价格
        $minPrice =DB::table(strtolower($this->app).'_price')->where(
            [
                'app_id' => array_get($data,'id'),
                'status' => 1
            ]
        )->min('price')?:0;


        // 商家信息
        if (($merchantId = array_get($data,'merchant_id',0)) > 0){
            $merchant = app('admin.abstract')->findById($merchantId)['name'];
        }else {
            $merchant = '无';
        }

        return [
            'minPrice' =>   $minPrice,
            'isFavorite' => $fa !== null? $fa->id:0,
            'avg' => number_format($avg,1),
            'appAlias' => config('extension')[$this->app]['alias'],
            'merchant' => $merchant,
            'starCoin' => $this->starsCoin(
                number_format($avg,1)
            ),
        ];
    }

    /**
     * 将图册转json
     * @param $data
     * @return array
     */
    public function _before_create($data){
        return [
            'thumbs' => json_encode($data['thumbs'])
        ];
    }

    /**
     * 将图册转json
     * @param $ids
     * @param $data
     * @return array
     */
    public function _before_update($ids,$data)
    {
        return array_get($data,'thumbs',false)?
                ['thumbs' => json_encode(array_get($data,'thumbs'))]
            :[];
    }

    /**
     * 评论星级
     * @param $stars
     * @return string
     */
    public function starsCoin($stars){
        $stars = explode('.', $stars);
        $pos =  isset($stars[1]) ? ($stars[1] >0 ? 5 : 0) : 0;
        return join('/',[
            env('APP_URL'),
            self::$starImg[join('.',[$stars[0], $pos])]
        ]);
    }

}