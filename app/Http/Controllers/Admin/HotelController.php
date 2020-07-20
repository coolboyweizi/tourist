<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;

class HotelController extends Controller
{
    /**
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.hotel.list');

    }

    public function create(){
        $tags = Tag::get();
        return view('admin.hotel.create',compact('id', 'tags'));
    }


    /**
     * 编辑页面
     * @param $id
     */
    public function edit($id)
    {
        $tags = Tag::get();
        return view('admin.hotel.edit', compact('id', 'tags'));
    }




}
