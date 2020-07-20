<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\StorageService ;

class UploadController extends Controller
{

    public function store(Request $request, StorageService $storageService)
    {
        $data = $storageService->upload('demo','img');
        var_dump($data);
        return;
    }

    public function demo(StorageService $storageService)
    {
        //var_dump($storageService->has($s));
        return view("demo");
    }
}
