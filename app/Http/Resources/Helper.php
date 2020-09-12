<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;
use PhpParser\Node\Stmt\TryCatch;

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

    public static function getIdOfCategoryOrCreateNew($categoryInput)
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

    public static function addProductOrEdit($productImput,$id='new')
    {
        if($id=='new')
        {
            $newProduct=new ModelsProduct(); 
        }
        else
        {
            $newProduct=ModelsProduct::findOrFail($id);
        }
          
        
        $newProduct->model=$productImput['model'];
        $newProduct->type=$productImput['type'];
        $newProduct->category=Helper::getIdOfCategoryOrCreateNew($productImput['category']);
        $newProduct->manufacturor=$productImput['manufacturor'];
        $newProduct->serial=$productImput['serial'];
        $newProduct->sku=$productImput['sku'];
        $newProduct->prise=$productImput['prise'];
        $newProduct->discount=$productImput['discount'];
        $newProduct->description=$productImput['description'];
        $newProduct->link=$productImput['link'];

        $newProduct->saveOrFail();  
    }

    public static function loadDataFromFile($filePath)
    {
        $file=fopen(storage_path($filePath), "r");
        $line=0;
        $report=['done'];
        while(! feof($file))
        {
            $line++;
            $dataArray=explode(',',fgets($file));

            if(count($dataArray)==10)
            {
                $product=[
                    'model'=>$dataArray[0],
                    'type'=>$dataArray[1],
                    'category'=>$dataArray[2],
                    'manufacturor'=>$dataArray[3],
                    'serial'=>$dataArray[4],
                    'sku'=>$dataArray[5],
                    'prise'=>$dataArray[6],
                    'discount'=>$dataArray[7],
                    'description'=>$dataArray[8],
                    'link'=>$dataArray[9]
                ];
               
                $partCheck=Helper::productValidator($product,$line);
                if(count($partCheck)==0)
                {
                   Helper::addProductOrEdit($product);  
                }
                else
                {
                    array_push($report,$partCheck);
                }
            }
            else
            {
                array_push($report,"Bad data (to many commas) on line $line");
            }
        }

        return json_encode($report);
    }

    public static function productValidator($productArray,$line)
    {
        $check=[];

        if(!isset($productArray)) array_push($check,"There is no product on line $line");
        Helper::validatePartProduct($productArray,$line,$check,'model','string');
        Helper::validatePartProduct($productArray,$line,$check,'type','string');
        Helper::validatePartProduct($productArray,$line,$check,'category','integer');
        Helper::validatePartProduct($productArray,$line,$check,'manufacturor','string');
        Helper::validatePartProduct($productArray,$line,$check,'serial','integer');
        Helper::validatePartProduct($productArray,$line,$check,'sku','integer');
        Helper::validatePartProduct($productArray,$line,$check,'prise','double');
        Helper::validatePartProduct($productArray,$line,$check,'discount','double');
        Helper::validatePartProduct($productArray,$line,$check,'description','string');
        Helper::validatePartProduct($productArray,$line,$check,'link','string');

        return $check;
    }

    public static function validatePartProduct($productArray,$line,$check,$name,$type)
    {
        if(!isset($productArray[$name]) and gettype($productArray[$name])==$type) array_push($check,"Bad $name on line $line");
    }

    public static function isSafeToDeleteCategory($id)
    {
       return (ModelsProduct::where('category',$id)->count()==0)? true:false;
    }
}
