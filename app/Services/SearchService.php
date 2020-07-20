<?php
/**
 * User: Master King
 * Date: 2018/12/10
 * Desc: 公共搜索
 */

namespace App\Services;

use App\Logic\AppPriceLogic;
use App\Models\HotelPriceModel;
use App\Models\ProjectPriceModel;
use App\Services\SearchService as SearchServiceConcract;
use App\Exceptions\AppException;
use App\Logic\AppLogic;
use App\Logic\SysOrderLogic;
use App\Models\BaseModel;
use App\Models\HotelModel;
use App\Models\OrderModel;
use App\Models\ProjectModel;
use App\Exceptions\ExceptionCode;
use App\Models\TravelModel;


class SearchService /*implements SearchServiceConcract*/
{

    /**
     * Which Model Support
     * @var array
     */
    private static $searchModel = [
        'travel' => TravelModel::class,
        'project'=> ProjectModel::class,
        'hotel'  => HotelModel::class,
        'projectPrice' => ProjectPriceModel::class,
        'hotelPrice' => HotelPriceModel::class,
        'order' => OrderModel::class,
    ];

    /**
     * Search Result Collections
     * @var string
     */
    private $searchRst = '';

    /**
     * 支持的app搜索应用
     * @var array
     */
    private static $appSearch = [
        'project','hotel'
    ];

    /**
     * 支持的orderService的搜索应用
     * @var array
     */
    private static $orderSearch = [
        'order'
    ];

    /**
     * @param $app
     * @param $keyWord
     * @param $limit
     * @return array
     * @throws AppException
     */
    public function search($app, $keyWord, $limit){

        try {
            $data = $this->model($app)::search($keyWord)->where('status',1)->paginate($limit);
        }catch (\Exception $exception) {
            throw new AppException("不支持搜索模型错误:".$exception->getMessage(),ExceptionCode::SEARCH_SERVICE_EXCEPTION);
        }

        $this->toResponse($data);

        // price
        if (strpos($app,'Price') > 0) {
            return $this->toAppPriceResponce($app);
        }elseif ($app == 'order') {
            return $this->toOrderResponce();
        }else {
            return $this->toAppResponce($app);
        }
    }

    /**
     * Get Model From APP
     * @param $app
     * @return BaseModel
     */
    private function model($app){
        return self::$searchModel[$app];
    }

    /**
     * @return array
     */
    private function toResponse($data)
    {
        // $this->searchRst->items = $this->searchRst->items->results;
        $this->searchRst = response()
            ->json($data)
            ->setEncodingOptions(JSON_UNESCAPED_UNICODE)
            ->original;
        //$this->searchRst->data = $this->searchRst->data->results;
    }

    /**
     * 返回App类的搜索结果
     * @return array
     */
    private function toAppResponce($app){
       return array_merge( (array) $this->searchRst,
           (new AppLogic($app))->_after_find_all( (array) $this->searchRst ));
    }

    private function toAppPriceResponce($app){
            $app = str_replace('Price','',$app);
            return (new AppPriceLogic($app))->_after_find_all( (array) $this->searchRst );
    }

    /**
     * 返回订单类的搜索结果
     */
    private function toOrderResponce(){
        return array_merge( (array) $this->searchRst,
            (new SysOrderLogic())->_after_find_all( (array) $this->searchRst)) ;
    }
}