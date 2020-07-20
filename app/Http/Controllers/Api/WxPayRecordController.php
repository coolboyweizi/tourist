<?php
/**
 * 支付相关服务
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception ;
use App\Http\Controllers\Controller;

class WxPayRecordController extends Controller
{
    /**
     * 获取列表
     * @return array
     */
    public function index(){
        try {
            $request = Request::capture();
            return [
                'code' => 0,
                'data' => app('wxPayRecord.abstract')->findAll([], $request->input('limit',10))
            ];
        }catch (Exception $exception) {
            return [
              'code' => $exception->getCode()?:ExceptionCode::PV_CONTROLLER_EXCEPTION,
              'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 删除数据
     * @param $id
     * @return array
     */
    public function destroy($id){
        try{
            $request = Request::capture();
            $ids = $request->input('ids','false')?:[$id];
            return [
                'code' => 0,
                'data' => app('wxPayRecord.abstract')->destroy($ids)
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::PV_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
