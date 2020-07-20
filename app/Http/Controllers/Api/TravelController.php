<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
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
                'data' => app('travel.abstract')->findAll(
                    $this->builderWhere('travel'),
                    $request->input('limit',10),
                    [
                        'recommend' => 'desc',
                        'created' => 'desc'
                    ]
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_CONTROLLER_EXCEPTION,
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
     * Store A Travel
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        try {
            return [
              'code' => 0,
              'data' => app('travel.abstract')->create($request, 1)
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Find A Travel By Id
     *
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function show($id)
    {
        try {
            return [
                'code'=>0,
                'data'=> app('travel.abstract')->findById($id)
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::PROJECT_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }


    public function edit($id)
    {
        //
    }

    /**
     * Update Travel Data
     *
     * @param Request $request      We Need $request->all()
     * @param $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        try {
            return [
                'code' => 0 ,
                'data' => app('travel.abstract')->update(
                    [$id],
                    $request->except("s")
                )
            ];
        }catch (\Exception $e) {
            return [
                'code' => $e->getCode()?:ExceptionCode::TRAVEL_CONTROLLER_EXCEPTION,
                'data' => $e->getMessage()
            ];
        }
    }

    /**
     * Delete A project
     *
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
                'data' => app('travel.abstract')->delete(
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
