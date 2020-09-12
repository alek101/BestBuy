<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category as ModelsCategory;
use Illuminate\Database\Eloquent\Model;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return json_encode(ModelsCategory::all());
    }

    public function update(Request $request)
    {
        $id=$request->id;
        $newName=$request->newName;
        $category=ModelsCategory::findOrFail($id);
        //if it is needed to be changed by name
        //$category=ModelsCategory::where('categoryName',$request->oldName)->first();
        $oldName=$category->categoryName;
        $category->categoryName=$newName;
        $category->saveOrFail();
        return json_encode("Saved $newName instead of $oldName");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //check if it is allowed-for future
        ModelsCategory::destroy($id);
        return json_encode("deleted");
    }
}
