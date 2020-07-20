<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{

    /**
     * Find List According Condition
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request)
    {
        try{
            return [
                'code' => 0,
                'data' => app('project.abstract')->findAll(
                    $this->builderWhere('project'),
                    $request->input('limit',10),
                    [
                        'recommend' => 'desc',
                        'created' => 'desc'
                    ]
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }

    }

    /**
     * view: create an project from background
     */
    public function create()
    {

    }

    /**
     * 来自后台。添加一个景区项目
     * @param Request $request
     * @return array
     */
    public function store(Request $request )
    {
        try {
            return [
              'code' => 0,
              'data' => app('project.abstract')->create(array_merge(
                  ['merchant_id' => Auth::id()],
                  $request->except('s')
              ))
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * 查看项目
     * @param $id
     * @return array
     */
    public function show($id)
    {
        try {
            return [
                'code'=>0,
                'data'=> app('project.abstract')->findById($id)
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * 后台更新某个项目
     * @param Request $request
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            $ids = $request->input('ids',false)?:[$id];
            return [
                'code' => 0 ,
                'data' => app('project.abstract')->update(
                    $ids,
                    $request->except("s")                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * 删除一个项目。做软删除
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
                'data' => app('project.abstract')->delete(
                    $ids,
                    $request->get('force',false),
                    Auth::id()
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }
}
