<?php

namespace App\Http\Controllers\Api;


use App\Exceptions\ExceptionCode;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ProjectOrderController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function store(
        Request $request
    )
    {
        try {
            return [
                'code' => 0 ,
                'data' => app('projectOrder.abstract')->create(
                    $request->except('s'),
                    Auth::id()
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
