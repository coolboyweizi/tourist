<?php

namespace App\Http\Controllers\Admin;

use App\Models\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = Site::pluck('value','key');
        return view('admin.site.index',compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token','_method','s']);
        if (empty($data)){
            return back()->withErrors(['status'=>'无数据更新']);
        }

        $count = 0 ;
        foreach (['shared','system'] as $key){
            $value = $request->input($key);
            if ($value < 0) {
                return back()->withErrors(['status'=>$key.'字段不能小于0']);
            }
            if ($value > 100) {
                return back()->withErrors(['status'=>$key.'字段不能大于100']);
            }
            $count = $value + $count;
        }

        if ($count > 100) {
            return back()->withErrors(['status'=>'分成比例不能超过100']);
        }

        Site::truncate();
        foreach ($data as $key=>$val){
            Site::create([
                'key' => $key,
                'value' => $val
            ]);
        }
        return back()->with(['status'=>'更新成功']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
