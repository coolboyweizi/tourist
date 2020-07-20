<?php
/**
 * User: Master King
 * Date: 2019/2/21
 */

namespace App\Http\Controllers;


use App\Models\ProfitModel;
use Carbon\Carbon;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class DemoController
{
    public function index(){
        $collections = ProfitModel::where('shared_uid',1)->paginate(10);
    }
}