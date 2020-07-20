<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectPriceController extends Controller
{
    /**
     * List
     * @param $app_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($app_id)
    {
        return view('admin.projectPrice.list', compact('app_id'));

    }

    public function create($app_id){
        return view('admin.projectPrice.create',compact('app_id'));
    }

    /**
     * Edit Form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $price = app('projectPrice.abstract')->findById($id);
        $app_id = array_get($price, 'app_id');
        return view('admin.projectPrice.edit', compact('id','app_id'));
    }


}
