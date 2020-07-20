<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exceptions\ExceptionCode;
use Illuminate\Support\Facades\Auth;

class TravelController extends Controller
{
    /**
     * 列表也
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.travel.list');

    }

    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $tags = Tag::get();
        return view('admin.travel.create',compact('tags'));
    }

    /**
     * 编辑页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tags = Tag::get();
        return view('admin.travel.edit', compact('id','tags'));
    }

}
