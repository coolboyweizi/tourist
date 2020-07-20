<?php

namespace App\Http\Controllers\Api;


use Exception;
use App\Exceptions\ExceptionCode;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * @return array
     */
    public function index()
    {
       try {

           $user = Auth::user();

           return [
               'code' => 0,
               'data' => [
                    'id' => $user->id,
                    'name' => $user->name
               ]
           ];
       }catch (Exception $exception) {
           return [
               'code' => $exception->getCode()?:ExceptionCode::GENERAL,
               'data' => env('APP_URL').'/index.html'
           ];
       }
    }

}
