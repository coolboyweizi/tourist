<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DailyPvController extends Controller
{
    public function index()
    {
        return [
            'code' => 0,
            'data' =>  app('dailypv.abstract')->findAll(
                [
                    ['created','>', strtotime('Y-m-d 0:0:0')],
                ],
                100,
                ['created'=>'desc']
            )
        ];
    }
}
