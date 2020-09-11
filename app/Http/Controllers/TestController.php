<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Helper;

class TestController extends Controller
{
    //

    public function test1()
    {
        $cat='test2';
        return json_encode(Helper::getIdOfCategory($cat));
    }
}
