<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
class HotelController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('hotel.abstract')->findAll(
                    $this->builderWhere('hotel'),
                    $request->input('limit',10),
                    [
                        'recommend' => 'desc',
                        'created' => 'desc'
                    ]
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_CONTROLLER_EXCEPTION,
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
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('hotel.abstract')->create(
                    array_merge(
                        ['merchant_id' => Auth::id()],
                        $request->except('s')
                    )
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::HOTEL_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage(),
            ];
        }
    }

    /**
     * 查看具体的酒店信息
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code'=>0,
                'data'=> app('hotel.abstract')->findById($id)
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::HOTEL_CONTROLLER_EXCEPTION,
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
     * 修改数据
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
                'data' => app('hotel.abstract')->update(
                    $ids,
                    $request->except("s")
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 删除
     *
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];

            return [
                'code' => 0,
                'data' => app('hotel.abstract')->delete(
                    $ids,
                    $request->input('force',false),
                    0
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOTEL_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
