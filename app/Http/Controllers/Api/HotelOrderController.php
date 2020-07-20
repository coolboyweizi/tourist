<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class HotelOrderController extends Controller
{

    public function index(Request $request)
    {
        try {
            return [
                'code' =>0,
                'data' => app('hotelOrder.abstract')->findAll(
                    $this->builderWhere('hotelOrder'),
                    $request->input('limit',10)
                )
            ];

        }catch (Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_ORDER_CONTROLLER_EXCEPTION,
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
     * Create An Order For Hotel
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('hotelOrder.abstract')->create(
                    $request->except('s'),
                    Auth::id()?:1
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_ORDER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 查看某个订单具体详情
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('hotelOrder.abstract')->findById($id)
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_ORDER_CONTROLLER_EXCEPTION,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
