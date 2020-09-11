<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Category;
use App\Models\Category as ModelsCategory;
use App\Product;

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
}
