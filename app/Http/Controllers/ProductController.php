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
        return json_encode(ModelsProduct::select('products.id as id','model_number','categories.categoryName as categoryName','department_name','manufacturer_name','upc','sku','regular_price','sale_price','description','url')
        ->leftJoin('categories','products.category_name','=','categories.id')
        ->get());
    }

    
    public function showProductsByCategoryID($id)
    {
        return json_encode(ModelsProduct::where('category_name',$id)
        ->select('products.id as id','model_number','categories.categoryName as categoryName','department_name','manufacturer_name','upc','sku','regular_price','sale_price','description','url')
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
        $request->validate([
            'id'=>'required|integer',
            'model_number'=>'required|string',
            'category_name'=>'required|string',
            'department_name'=>'required|string',
            'manufacturer_name'=>'required|string',
            'upc'=>'required|numeric',
            'sku'=>'required|numeric',
            'regular_price'=>'required|numeric',
            'sale_price'=>'required|numeric',
            'description'=>'required|string',
            'url'=>'required|string'
        ]);
        
        $productImput=[
            'model_number'=>$request->model_number,
            'category_name'=>$request->category_name,
            'department_name'=>$request->department_name,
            'manufacturer_name'=>$request->manufacturer_name,
            'upc'=>$request->upc,
            'sku'=>$request->sku,
            'regular_price'=>$request->regular_price,
            'sale_price'=>$request->sale_price,
            'description'=>$request->description,
            'url'=>$request->url
        ];

        Helper::addProductOrEdit($productImput,$request->id);
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
        ModelsProduct::destroy($id);
        return json_encode("deleted");
    }

    public function shortLink(Request $request)
    {
        $request->validate([
            'id'=>'required|integer',
        ]);

        $product=ModelsProduct::findOrFail($request->id);
        $product->url=Helper::transformLink($product->url);
        $product->saveOrFail();
        return json_encode("URL of product with id of $request->id have been shorten!");
    }
}
