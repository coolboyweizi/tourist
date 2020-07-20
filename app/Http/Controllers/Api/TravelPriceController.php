<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Exceptions\ExceptionCode ;

class TravelPriceController extends Controller
{
    /**
     * Get Price
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('travelPrice.abstract')->findAll(
                    $this->builderWhere('travelPrice'),
                    $request->input('limit',10)
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }


    /**
     * Add Price For Travels
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            $travel = app('travel.abstract')->findById($request->get('app_id',0));
            if ($travel['status'] < 1) {
                return [
                    'code' => ExceptionCode::TRAVEL_PRICE_CONTROLLER_EXCEPTION,
                    'data' => "项目编号：".$request->get('pid',0)." 不可用"
                ];
            }

            return [
                'code' => 0,
                'data' => app('travelPrice.abstract')->create(
                    $request,
                    1
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Get Price From Travel Price Service
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('travelPrice.abstract')->findById($id)
            ];
        } catch (\Exception $exception) {
            return [
                'code' => ExceptionCode::TRAVEL_PRICE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }


    public function edit($id)
    {

    }

    /**
     * Update Price For Travel
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('travelPrice.abstract')->update(
                    [$id],
                    $request->except('s')
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('travelPrice.abstract')->delete(
                    [$id],
                    $request->input('force',false),
                0
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        }
    }
}
