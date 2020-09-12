<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product as ModelsProduct;
use App\Http\Resources\Helper;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(ModelsProduct::select('products.id as id','model','categories.categoryName as category','type','manufacturor','serial','sku','prise','discount','description','link')
        ->leftJoin('categories','products.category','=','categories.id')
        ->get());
    }

    
    public function showProductsByCategoryID($id)
    {
        return json_encode(ModelsProduct::where('category',$id)
        ->select('products.id as id','model','categories.categoryName as category','type','manufacturor','serial','sku','prise','discount','description','link')
        ->leftJoin('categories','products.category','=','categories.id')
        ->get());
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
        $productImput=[
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
        $id=4;
        Helper::addProduct($productImput,$id);
        return json_encode('Saved');
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
