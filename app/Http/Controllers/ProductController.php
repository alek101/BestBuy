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
        return json_encode(ModelsProduct::select('products.id as id','model','categories.categoryName as category','department','manufacturor','upc','sku','prise','discount','description','link')
        ->leftJoin('categories','products.category','=','categories.id')
        ->get());
    }

    
    public function showProductsByCategoryID($id)
    {
        return json_encode(ModelsProduct::where('category',$id)
        ->select('products.id as id','model','categories.categoryName as category','department','manufacturor','upc','sku','prise','discount','description','link')
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
            'model'=>'required|string',
            'category'=>'required|string',
            'department'=>'required|string',
            'manufacturor'=>'required|string',
            'upc'=>'required|numeric',
            'sku'=>'required|numeric',
            'prise'=>'required|numeric',
            'discount'=>'required|numeric',
            'description'=>'required|string',
            'link'=>'required|string'
        ]);

        $productImput=[
            'model'=>$request->model,
            'category'=>$request->category,
            'department'=>$request->department,
            'manufacturor'=>$request->manufacturor,
            'upc'=>$request->upc,
            'sku'=>$request->sku,
            'prise'=>$request->prise,
            'discount'=>$request->discount,
            'description'=>$request->description,
            'link'=>$request->link
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
}
