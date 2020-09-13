<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Helper;

class TesterController extends Controller
{
    public function testGuzz()
    {
        $url='https://laravel.com/docs/7.x/http-client';
        $result=Helper::transformLink($url);
        return json_encode($result);
    }
}
