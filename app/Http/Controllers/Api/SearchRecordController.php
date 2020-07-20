<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\Controller;

class SearchRecordController extends Controller
{
    public function index(){
        try {
            $result = app('searchRecord.abstract')->findAll([
                ['times' ,'=', date('ymd')],
            ],10,['count' => 'desc']);
            return [
                'code' => 0,
                'data' => $result['data'],
                'count' => $result['total']
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::SEARCH_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage(),
            ];
        }
    }
}
