<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\AppException;
use Illuminate\Http\Request;
use App\Exceptions\ExceptionCode;
use Illuminate\Support\Facades\Auth;

class WithdrawController extends Controller
{

    /**
     * Get User Withdraw List
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('withdraw.abstract')->findAll(
                    $this->builderWhere('withdraw'),
                    $request->input('limit',10)
                )
            ];

        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::MONEY_LOG_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage(),
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
     * Create A New WithDraw Record
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            $uid = $request->input('uid', false);

            if ($uid === false  ||  Auth::id() != $uid ) {
                throw new AppException("用户验证失败", ExceptionCode::WITHDRAW_CONTROLLER_EXCEPTION);
            }

            return [
                'code' =>0,
                'data' => app('withdraw.abstract')->create(
                    array_merge(
                        $request->except('s'),[
                            'uid' => $uid
                    ]),
                    $uid
                )
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::WITHDRAW_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * Get One Withdraw Record
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('withdraw.abstract')->findById($id)
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::WITHDRAW_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }


    public function edit($id)
    {
        //
    }

    /**
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
                'data' => app('withdraw.abstract')->update(
                    $ids,
                    [
                        'status' => $request->input('status',0)
                    ],
                    0
                )
            ];
        }catch (\Exception $exception){
            return [
                'code' => $exception->getCode()?:$exception->getCode(),
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * Delete WithDraw Record
     *
     * @param $id    key Id in WithDraw。
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];
            return [
                'code' => 0,
                'data' => app('withdraw.abstract')->delete(
                    $ids,
                    $request->input('force', false),
                    0
                )
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::WITHDRAW_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
