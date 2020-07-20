<?php
/**
 * @desc 今日热门模块
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class HotAppController extends Controller
{
    public function index(){
        try{
            $result = app('hotApp.abstract')->findAll([
                ['times','=',date('ymd')]
            ],10,[
                'count' => 'desc'
            ]);
            return [
                'code' => 0,
                'data' => $result['data'],
                'count' => $result['total']
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
