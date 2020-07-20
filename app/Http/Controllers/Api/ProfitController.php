<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfitController extends Controller
{
    public function index(){
        try {
            return [
                'code' => 0,
                'data' => app('profit.abstract')->findAll(
                    $this->builderWhere('profit'),
                    Request::capture()->input('limit',10)
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::PROFIT_CONTROLLER_EXCEPTION  ,
                'data' => $exception->getMessage()
            ];
        }
    }
}
