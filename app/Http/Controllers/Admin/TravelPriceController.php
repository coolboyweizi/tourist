<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class TravelPriceController extends Controller
{
    /**
     * List
     * @param $app_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($app_id)
    {
        return view('admin.travelPrice.list', compact('app_id'));

    }

    public function create($app_id){
        return view('admin.travelPrice.create',compact('app_id'));
    }

    /**
     * Edit Form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $price = app('travelPrice')->findById($id);
        $app_id = array_get($price, 'app_id');
        return view('admin.travelPrice.edit', compact('id','app_id'));
    }


}
