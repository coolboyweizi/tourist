<?php
/**
 * @user: master king
 * @date: 2018-12-04
 * @desc: 新闻
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class NewsController extends Controller
{
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
                'data' => app('news.abstract')->findAll(
                    $this->builderWhere('new'),
                    $request->input('limit',10)
                )
            ];

        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::NEWS_CONTROLLER_EXCEPTION,
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
            $id = array_get($request, 'id');
            return [
                'code' => 0,
                'data' => app('news.abstract')->create
                (
                    $request->except('s'),
                    1
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::NEWS_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];

        }
    }

    /**
     * 查看具体的快报
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {

        try {
            return [
                'code'=>0,
                'data'=> app('news.abstract')->findById($id)
            ];
        }catch (\Exception $e) {

            return [
                'code' => $e->getCode()?:ExceptionCode::NEWS_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];
            return [
                'code' => 0,
                'data' => app('news.abstract')->update(
                    $ids,
                    $request->except('s'),
                    0
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::NEWS_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
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
                'data' => app('news.abstract')->delete(
                    $ids,
                    true,
                    0
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::NEWS_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }
}
