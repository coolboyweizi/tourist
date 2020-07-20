<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;

class TalentPriceController extends Controller
{

    public function index()
    {
        try {
            return [
                'code' => 0,
                'data' => app('talentPrice.abstract')->findAll(
                    $this->builderWhere('talentPrice'),
                    Request::capture()->input('limit',10)
                )
            ];
        }catch (Exception $exception){
            return [
                'code' => $exception->getCode()?:ExceptionCode::TALENT_PRICE_CONTROLLER_EXCEPTION,
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
            return [
                'code' => 0,
                'data' => app('talentPrice.abstract')->findAll(
                   [
                       ['app_id',$id]
                   ],
                    Request::capture()->input('limit',10)
                )
            ];
        }catch (Exception $exception){
            return [
              'code' => $exception->getCode()?:ExceptionCode::TALENT_PRICE_CONTROLLER_EXCEPTION,
              'data' => $exception->getMessage(),
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
