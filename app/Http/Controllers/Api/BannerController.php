<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;

class BannerController extends Controller
{
    private static $apps = ['project', 'hotel'];
    /**
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('banner.abstract')->findAll(
                    $this->builderWhere('banner'),
                    $request->input('limit',10)
                )
            ];

        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::BANNER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage(),
            ];
        }
    }


    public function create()
    {

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
                'data' => app('banner.abstract')->create
                (
                    $request->except('s'),
                    0
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::BANNER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];

        }
    }

    /**
     * 查看具体的项目
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        //
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
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try {
            $ids = $request->input('ids')?:[$id];
            return [
                'code' => 0,
                'data' => app('banner.abstract')->delete(
                    $ids,
                    true,
                    0
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::BANNER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
