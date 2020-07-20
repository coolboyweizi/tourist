<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Exception;
use App\Exceptions\ExceptionCode;

class HotelPriceController extends Controller
{
    /**
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('hotelPrice.abstract')->findAll(
                    $this->builderWhere('hotelPrice'),
                    $request->input('limit',10)
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
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
     * 添加酒店订单
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try{
            return [
                'code' => 0,
                'data' => app('hotelPrice.abstract')->create(
                    $request,
                    0
                )
            ];
        }catch (Exception $exception){

            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 单个票价查询
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code'=>0,
                'data'=> app('hotelPrice.abstract')->findById($id)
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::HOTEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
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
     * 更新
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            $ids = $request->input('ids', false)?:[$id];
            return [
                'code' => 0,
                'data' => app('hotelPrice.abstract')->update(
                    $ids,
                    $request->except('s'),
                    0
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * Delete A project
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];
            return [
                'code' => 0 ,
                'data' => app('hotelPrice.abstract')->delete(
                    $ids,
                    $request->get('force',false),
                    0
                )
            ];
        } catch (Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::HOTEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }
}
