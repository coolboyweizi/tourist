<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TalentPriceController extends Controller
{
    public function index($app_id)
    {
        return view('admin.talentPrice.list', compact('app_id'));
    }
}
