<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;

class TalentOrderController extends Controller
{

    /**
     * 添加订单
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talentOrder.abstract')->create(
                 $request->except('s'),
                 Auth::id()
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_ORDER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

}
