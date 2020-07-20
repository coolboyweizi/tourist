<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TalentController extends Controller
{
    /**
     * @return array
     */
    public function index()
    {
        try {
            return [
                'code' => 0,
                'data' => app('talent.abstract')->findAll(
                    $this->builderWhere('talent'),
                    Request::capture()->input('limit',10)
                    )
            ];
        }catch (\Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::TRAVEL_CONTROLLER_EXCEPTION,
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
     * 添加数据
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
               'code' => 0,
               'data' => app('talent.abstract')->create(
                   $request->except('s')
               )
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talent.abstract')->findById($id)
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_CONTROLLER_EXCEPTION,
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
     * 更新数据
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talent.abstract')->update([$id], $request->except('s')),
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 删除数据
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talent.abstract')->delete([$id]),
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
