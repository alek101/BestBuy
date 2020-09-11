<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;


class Helper extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    public static function getIdOfCategory($categoryInput)
    {
        $foundCategory=ModelsCategory::where('categoryName',$categoryInput);
        if($foundCategory->count()>0)
        {
            return $foundCategory->first()->id;
        }
        else
        {
            $newCategory=new ModelsCategory();
            $newCategory->categoryName=$categoryInput;
            $newCategory->saveOrFail();
            return ModelsCategory::where('categoryName',$categoryInput)->first()->id;
        }
    }

    public static function addProduct($productImput)
    {
        $newProduct=new ModelsProduct();   
        
        $newProduct->model=$productImput['model'];
        $newProduct->type=$productImput['type'];
        $newProduct->category=Helper::getIdOfCategory($productImput['category']);
        $newProduct->manufacturor=$productImput['manufacturor'];
        $newProduct->serial=$productImput['serial'];
        $newProduct->sku=$productImput['sku'];
        $newProduct->prise=$productImput['prise'];
        $newProduct->discount=$productImput['discount'];
        $newProduct->description=$productImput['description'];
        $newProduct->link=$productImput['link'];

        $newProduct->saveOrFail();
        
    }
}
