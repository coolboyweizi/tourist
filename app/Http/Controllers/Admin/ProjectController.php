<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * 列表也
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.project.list');

    }

    /**
     * 添加页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $tags = Tag::get();
        return view('admin.project.create',compact('tags'));
    }

    /**
     * 编辑页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $tags = Tag::get();
        return view('admin.project.edit', compact('id','tags'));
    }

}
