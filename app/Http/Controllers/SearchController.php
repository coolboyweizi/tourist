<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\SearchService;
use Illuminate\Http\Request;
use App\Exceptions\ExceptionCode;

class SearchController extends Controller
{
    /**
     * 搜索列表
     * @param SearchService $searchService
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchService $searchService)
    {
        try {
            $request = \Illuminate\Http\Request::capture();

            if ($request->input('app',false) == 'travel') {
                $data = app('travel.abstract')->findAll([
                    ['departure','like' ,'%'.$request->input('departure').'%'],
                    ['destination','like' ,'%'.$request->input('destination').'%'],
                    ['status','=',1]

                ], $request->input('limit',10));
            }else {
                $data = $searchService->search(
                    $request->input('app','project'),
                    $request->input('keywords',''),
                    $request->input('limit',10)
                );
            }

            $code = 0;
        }catch (Exception $exception) {
            $code = $exception->getCode()?:ExceptionCode::SEARCH_CONTROLLER_EXCEPTION;
            $data = $exception->getMessage();
        }

        return response()->json(
            [
                'code' => $code,
                'data' => $data
            ]
        )->setEncodingOptions(JSON_UNESCAPED_UNICODE);;

    }
}
