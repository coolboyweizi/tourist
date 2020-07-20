<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;

class RecommendController extends Controller
{
    private static $apps = ['project', 'hotel','travel'];

    /**
     * 分页列表
     *
     * @param Request $request
\     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('recommend.abstract')->findAll(
                    $this->builderWhere('recommend'),
                    $request->input('limit',10)
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::RECOMMEND_CONTROLLER_EXCEPTION,
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
     * 推荐
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('recommend.abstract')->create(
                    $request->except('s')
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::RECOMMEND_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * 删除，批量删除推荐
     * @param $id
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try{
            $ids = $request->input('ids', false)?:[$id];
            return [
                'code' => 0,
                'data' => app('recommend.abstract')->destroy(
                  $ids
                )
            ];
        }catch (Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::RECOMMEND_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }
}
