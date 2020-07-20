<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tag;
class TalentUserController extends Controller
{
    public function index()
    {
        return view('admin.talentUser.list');
    }

    public function create(){
        $tags = Tag::get();
        return view('admin.talentUser.create',compact('id', 'tags'));
    }

    public function edit($id)
    {
        $tags = Tag::get();
        return view('admin.talentUser.edit', compact('id', 'tags'));
    }
}
