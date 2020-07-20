<?php

namespace App\Http\Controllers\Admin;


use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;

class HotController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return array_merge(
                [
                    'code'  => 0,
                    'msg'   => ''
                ],
                app('hotapp.abstract')->findAll([], $request->input('limit',10),['count'=>'desc'])
            );
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::HOT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}