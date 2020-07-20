<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019\1\4 0004
 * Time: 10:13
 */

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class TravelOrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            return [
                'code' =>0,
                'data' => app('travelOrder.abstract')->findAll(
                    $this->builderWhere('travelOrder'),
                    $request->input('limit',10)
                )
            ];

        }catch (Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_ORDER_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
                'code' => 0 ,
                'data' => app('travelOrder.abstract')->create(
                    $request->except('s'),
                    Auth::id()?:1
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_ORDER_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function show($id)
    {
        // 查询单个订单
        try {
            return [
                'code' => 0,
                'data' => app('travelOrder.abstract')->findById($id)
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::TRAVEL_ORDER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {

            $ids = $request->input('ids',false)?:[$id];

            return [
                'code' => 0,
                'data' => app('travelOrder.abstract')->update(
                    $ids,
                    $request->except(['s','ids']),
                    0
                )
            ];

        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_ORDER_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage(),
            ];
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try {
            return [
                'code' => 0 ,
                'data' => app('travelOrder.abstract')->delete(
                    [$id],
                    false,
                    0
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_ORDER_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }
}