<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class HotelPriceController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($app_id)
    {
        return view('admin.hotelPrice.list', compact('app_id'));

    }

    public function create($app_id){
        return view('admin.hotelPrice.create',compact('app_id'));
    }


    /**
     * 编辑页面
     * @param $id
     */
    public function edit($id)
    {
        $price = app('hotelPrice.abstract')->findById($id);
        $app_id = array_get($price, 'app_id');
        return view('admin.hotelPrice.edit', compact('id','app_id'));
    }

}
