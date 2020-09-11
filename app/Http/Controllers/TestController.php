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

    public function test2()
    {
        $cat=[
            'model'=>'model',
            'type'=>'type',
            'category'=>'category',
            'manufacturor'=>'filps',
            'serial'=>1213113,
            'sku'=>2323,
            'prise'=>12.11,
            'discount'=>10.11,
            'description'=>'opis',
            'link'=>'link'
        ];

        Helper::addProduct($cat);

        return json_encode('uradjeno');
    }

}
