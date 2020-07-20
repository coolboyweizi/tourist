<?php

namespace App\Http\Controllers;

use App\Contracts\StorageService;
use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param LaravelService $service
     * @return array
     */
    public function store(Request $request, StorageService $service)
    {
        try {
            $upload = $service->upload('xinyishidai-staging',  Request::capture()->file('img')->path());
            return [
                'code' => 0,
                'data' => $upload['oss-request-url']
            ];
        }catch (\Exception $exception) {
            return [
                'code' => $exception->getCode()?:ExceptionCode::STORAGE_COMMON,
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
