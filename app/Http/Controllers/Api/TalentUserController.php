<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TalentUserController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('talentUser.abstract')->findAll(
                    $this->builderWhere('talentUser'),
                    $request->input('limit',15)
                )
            ];
        }catch (Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::TALENT_USER_CONTROLLER_EXCEPTION,
              'data' => $exception->getMessage()
            ];
        }
    }


    /**
     * 删除
     * @param $id
     * @return array
     */
    public function destroy($id)
    {
        try {
            return [
              'code' => 0,
              'data' => app('talentUser.abstract')->destroy([$id])
            ];
        }catch (Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::TALENT_USER_CONTROLLER_EXCEPTION,
              'data' => $exception->getMessage()
            ];
        }
    }
}
