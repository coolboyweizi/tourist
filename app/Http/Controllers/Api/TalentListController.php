<?php
/**
 * 达人线路定制列表
 */
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ExceptionCode;
use Exception;

class TalentListController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            $dataList = app('talentList.abstract')->findAll(
                $this->builderWhere('talentList'),
                $request->input('limit',10)
            );
            $talent = app('talent.abstract')->findById($request->input('talent_id'));
            $data = array_merge(
              $dataList,
              ['price' => $talent['minPrice']]
            );
            return [
                'code' => 0,
                'data' => $data
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_LIST_CONTROLLER_EXCEPTION,
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
                'data' => app('talentList.abstract')->create(
                    $request->except('s')
                )
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_LIST_CONTROLLER_EXCEPTION,
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
     * 删除记录
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try{
            return [
              'code' => 0,
              'data' => app('talentList.abstract')-> destroy([$id]),
            ];
        }catch (\Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::TALENT_LIST_CONTROLLER_EXCEPTION,
              'data' => $exception->getMessage()
            ];
        }
    }
}
