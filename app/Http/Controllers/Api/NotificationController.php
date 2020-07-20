<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    /**
     * 关联服务
     * @var \Illuminate\Foundation\Application|mixed|null
     */
    private $service = null;

    /**
     * 构造器
     * NotificationController constructor.
     */
    public function __construct()
    {
        $this->service = app('notification.abstract');
    }

    /**
     * 先确定是否有类型。没有类型则挨个返回1条
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => $this->service->findAll(
                    [
                        'type'=>$request->input('type'),
                        'uid'  =>Auth::id()
                    ],
                    $request->input('limit',10)
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::NOTIFICATION_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * 通知用户概览。仅接受小程序
     */
    public function overView(){
        try {
            return [
                'code' => 0,
                'data' => $this->service->overview(Auth::id())
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::NOTIFICATION_CONTROLLER_EXCEPTION,
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
        try{
            //$type = $request->input('type','system');
            /*if ($type !== 'system') {
                throw new Exception("消息类型不支持");
            }*/
            return [
                'code' => 0,
                'data' => $this->service->create(
                    $request->except('s'),
                    $request->input('uid')
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::NOTIFICATION_CONTROLLER_EXCEPTION,
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
