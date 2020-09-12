<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Helper;

class FileController extends Controller
{
    public function index() 
    {
        return view('uploadfile');
    }

    public function addCSV(Request $request)
    {
        
        $request->validate([
            'csv'=>'required'
        ]);

        $file = $request->file('csv');
        $name = $file->getClientOriginalName();
        $file->move('/storage',$name);
        return json_encode(Helper::loadDataFromFile($name));
    }
}
