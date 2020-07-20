<?php

namespace App\Http\Controllers\Admin;

use App\Models\WxPayRecordModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WxPayRecordController extends Controller
{
    /**
     * list
     * @param Request $request
     * @return array
     */
    public function index(Request $request){
        $model = WxPayRecordModel::query();
        return [
          'code' => 0,
          'data' => $model->paginate($request->input('limit',15))->toArray()
        ];
    }

    public function view(){
        return view('admin.wxPay.list');
    }
}
