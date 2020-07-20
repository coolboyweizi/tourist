<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{
    /**
     * 评论关联的Service
     * @var \Illuminate\Foundation\Application|mixed|null
     */
    private $service = null;

    public function __construct()
    {
        $this->service = app('comment.abstract');
    }

    /**
     * 获取评论列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try{
            return [
                'code' => 0,
                'data' => $this->service->findAll(
                    $this->builderWhere('comment'),
                    $request->input('limit',5)
                )
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::COMMENT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }


    /**
     * 创建评论
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try{
            return [
                'code' => 0,
                'data' => $this->service->create(
                    $request->except('s'),
                    Auth::id()
                )
            ];
        }catch (\Exception$ce) {
            return [
                'code' => $ce->getCode()?:ExceptionCode::COMMENT_CONTROLLER_EXCEPTION,
                'data' => $ce->getMessage(),
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * 更新一条评论
     *
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
                'data' => $this->service->update(
                    $ids,
                    $request->except(['s','ids']),
                    0
                )
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::COMMENT_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 删除一条评论
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function destroy($id, Request $request)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];
            return [
                'code' => 0,
                'data' => $this->service->delete(
                    $ids
                )
            ];
        }catch (\Exception $exception) {
            return [
              'code' => $exception->getCode()?:ExceptionCode::COMMENT_CONTROLLER_EXCEPTION,
              'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * check Validate data
     * @param Request $data
     */
    public function validator(Request $data)
    {
        $this->validate($data, [
            'uid' => 'required|int',
            'data' => 'required|string',
        ]);
    }

}
