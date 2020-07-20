<?php
/**
 * 微信接口订单
 */
namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    /**
     * 系统订单查询列表
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('order.abstract')->findAll(
                    $this->builderWhere('order'),
                    $request->input('limit',10)
                )
            ];
        }catch (Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::ORDER_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            //$this->authorize('view',$orderModel);

            return [
                'code' => 0,
                'data' => app('order.abstract')->findById($id)
            ];
        }catch (Exception $e) {
            return [
              'code' => $e->getCode()?:ExceptionCode::ORDER_CONTROLLER_EXCEPTION,
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

    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('order.abstract')->update(
                    [$id],
                    $request->only(['status'])
                )
            ];
        }catch (Exception $exception) {
            return [
                'code' => $exception->getCode()?: ExceptionCode::ORDER_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];
            return [
                'code' => 0 ,
                'data' => app('order.abstract')->delete(
                    $ids,
                    $request->get('force',false)
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::ORDER_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }
}
