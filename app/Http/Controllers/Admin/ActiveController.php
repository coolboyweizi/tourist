<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActiveController extends Controller
{
    /**
     * 活动列表页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.active.list');
    }

    /**
     * 活动添加页面
     * @param string $app 关联的app
     * @param int $price_id 关联的价格
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($app, $price_id){
        $app = array_merge(
            app($app.'Price.abstract')->findById($price_id),
            ['type' => $app]
        );
        return view('admin.active.create',compact('app','price_id'));
    }

    /**
     * 编辑页
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        return view('admin.active.edit', compact('id'));
    }
}
