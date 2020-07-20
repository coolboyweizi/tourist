<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TalentGroupController extends Controller
{
    /**
     * 获取达人组列表
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talentGroup.abstract')->findAll(
                    $this->builderWhere('talentGroup'),
                    $request->input('limit',15)
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_GROUP_CONTROLLER_EXCEPTION,
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


    public function store(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talentGroup.abstract')->create(array_merge(
                    $request->except('s'),
                    ['status'=>1]
                ))
            ];
        }catch (Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::TALENT_GROUP_CONTROLLER_EXCEPTION,
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
