<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Controllers\Controller;

class TalentGroupController extends Controller
{

    public function index()
    {
        return view('admin.talentGroup.list');

    }

    public function create(){
        $tags = Tag::get();
        return view('admin.talentGroup.create',compact('id', 'tags'));
    }



    public function edit($id)
    {
        $tags = Tag::get();
        return view('admin.talentGroup.edit', compact('id', 'tags'));
    }

}
