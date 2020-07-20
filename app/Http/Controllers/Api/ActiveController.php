<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class ActiveController extends Controller
{

    public function index()
    {
        try {
            return [
                'code' => 0,
                'data' => app('active.abstract')->findAll(
                    $this->builderWhere('active'),
                    Request::capture()->input('limit',10)
                )
            ];
        }catch (Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::GENERAL,
              'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 添加活动规则
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('active.abstract')->create($request->except('s'))
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::GENERAL,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 查询单条活动规则
     * @param $id
     * @return array
     */
    public function edit($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('active.abstract')->findById($id)
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::GENERAL,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 更新一条活动规则
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('active.abstract')->update([$id], $request->except('s'))
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::GENERAL,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 删除一条规则
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('active.abstract')->delete([$id])
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::GENERAL,
                'data' => $exception->getMessage()
            ];
        }
    }
}
