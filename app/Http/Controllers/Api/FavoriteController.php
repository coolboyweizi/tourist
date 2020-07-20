<?php
/**
 * @user: master king
 * @date: 2018-12-04
 * @desc: 收藏
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    /**
     * 收藏列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
                return [
                    'code' => 0,
                    'data' => app('favorite.abstract')->findAll(
                        $this->builderWhere('favorite'),
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
     * 发起关注
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {

            return [
                'code' => 0,
                'data' => app('favorite.abstract')->create(
                    $request->except('s'),
                    Auth::id()?:1
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::FAVORITE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 取消关注，把status换0
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
                'data' => app('favorite.abstract')->destroy(
                    $ids
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::FAVORITE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
