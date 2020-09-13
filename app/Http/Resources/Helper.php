<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Category as ModelsCategory;
use App\Models\Product as ModelsProduct;
use Illuminate\Support\Facades\Http;

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
          
        
        $newProduct->model_number=$productImput['model_number']; 
        $newProduct->category_name=Helper::getIdOfCategoryOrCreateNew($productImput['category_name']);
        $newProduct->department_name=$productImput['department_name'];
        $newProduct->manufacturor=$productImput['manufacturor'];
        $newProduct->upc=$productImput['upc'];
        $newProduct->sku=$productImput['sku'];
        $newProduct->regular_price=$productImput['regular_price'];
        $newProduct->sale_price=$productImput['sale_price'];
        $newProduct->description=$productImput['description'];
        $newProduct->url=$productImput['url'];

        $newProduct->saveOrFail();  
    }

    public static function loadDataFromFile($fileName)
    {
        $file=fopen(storage_path('storage/'.$fileName), "r");
        $line=0;
        $report=['done'];
        while(! feof($file))
        {
            $line++;
            $dataArray=explode(',',fgets($file));
            if($line>1)
            {
                if(count($dataArray)==10)
                {
                    $product=[
                        'model_number'=>$dataArray[0],
                        'category_name'=>$dataArray[1],
                        'department_name'=>$dataArray[2],        
                        'manufacturor'=>$dataArray[3],
                        'upc'=>$dataArray[4],
                        'sku'=>$dataArray[5],
                        'regular_price'=>$dataArray[6],
                        'sale_price'=>$dataArray[7],
                        'description'=>$dataArray[8],
                        'url'=>$dataArray[9]
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
        }

        return json_encode($report);
    }

    public static function productValidator($productArray,$line)
    {
        $check=[];

        if(!isset($productArray)) array_push($check,"There is no product on line $line");
        Helper::validatePartProduct($productArray,$line,$check,'model_number','string');
        Helper::validatePartProduct($productArray,$line,$check,'category_name','integer');
        Helper::validatePartProduct($productArray,$line,$check,'department_name','string');
        Helper::validatePartProduct($productArray,$line,$check,'manufacturor','string');
        Helper::validatePartProduct($productArray,$line,$check,'upc','integer');
        Helper::validatePartProduct($productArray,$line,$check,'sku','integer');
        Helper::validatePartProduct($productArray,$line,$check,'regular_price','double');
        Helper::validatePartProduct($productArray,$line,$check,'sale_price','double');
        Helper::validatePartProduct($productArray,$line,$check,'description','string');
        Helper::validatePartProduct($productArray,$line,$check,'url','string');

        return $check;
    }

    public static function validatePartProduct($productArray,$line,$check,$name,$type)
    {
        if(!isset($productArray[$name]) and gettype($productArray[$name])==$type) array_push($check,"Bad $name on line $line");
    }

    public static function isSafeToDeleteCategory($id)
    {
       return (ModelsProduct::where('category_name',$id)->count()==0)? true:false;
    }

    public static function transformLink($url)
    {
        //https://laravel.com/docs/7.x/http-client
        $response = Http::post('https://rel.ink/api/links/', [
            'url' => $url
        ]);
        return 'https://rel.ink/api/links/'.$response->json()['hashid'].'/';
    }
}
