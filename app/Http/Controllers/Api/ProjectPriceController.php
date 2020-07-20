<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;
use App\Exceptions\ExceptionCode ;

class ProjectPriceController extends Controller
{
    /**
     * Get Price
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('projectPrice.abstract')->findAll(
                    $this->builderWhere('projectPrice'),
                    $request->input('limit',10)
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_PRICE_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        //
    }


    /**
     * Add Price For Projects
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {

        try {
            $project = app('project.abstract')->findById($request->get('app_id',0));
            if ($project['status'] < 1) {
                return [
                    'code' => ExceptionCode::PROJECT_PRICE_CONTROLLER_EXCEPTION,
                    'data' => "项目编号：".$request->get('pid',0)." 不可用"
                ];
            }

            return [
                'code' => 0,
                'data' => app('projectPrice.abstract')->create(
                    $request,
                    1
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_PRICE_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Get Price From Project Price Service
     *
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('projectPrice.abstract')->findById($id)
            ];
        } catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::PROJECT_PRICE_CONTROLLER_EXCEPTION,
                'data' => $exception->getMessage()
            ];
        }
    }


    public function edit($id)
    {

    }

    /**
     * Update Price For Project
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            return [
                'code' => 0,
                'data' => app('projectPrice.abstract')->update(
                    [$id],
                    $request->except('s'),
                    \Auth::id()? \Auth::id():1
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return array
     */
    public function destroy($id,  Request $request)
    {
        try {
            return [
                'code' => 0,
                'data' => app('projectPrice.abstract')->delete(
                    [$id],
                    $request->input('force',false),
                0
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'data' => $e->getMessage()
            ];
        }
    }
}
