<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Session;
use Hash;
use View;
use Input;
use Image;
use DB;

use App\Models\Misc;

class Library extends Model
{
  
  public function getLibraryList($data){
    
    $UserID=$data['UserID'];
    
    $Status=$data['Status'];
    $SearchText=$data['SearchText'];
    
    $Limit=$data['Limit'];
    $PageNo=$data['PageNo'];
    
    $query = DB::table('products as prds')
      ->join('customer_libraries as lib', 'prds.id', '=', 'lib.product_id') 
    
       ->selectraw("
          prds.id as book_ID,

          COALESCE(prds.name,'') as name,
          COALESCE(prds.author,'') as author,
          COALESCE(prds.subtitle,'') as subtitle,
          COALESCE(prds.short_description,'') as short_description,
          
          COALESCE(prds.slug,'') as slug,
          COALESCE(prds.file_url,'') as file_url,          

          COALESCE(prds.category_id,0) as category_id,
          COALESCE(prds.book_type,'') as book_type,          
      
          COALESCE(prds.sku,'') as sku,          
          COALESCE(prds.size,'') as size,
          COALESCE(prds.weight,'') as weight,
          COALESCE(prds.texture,'') as texture,
          COALESCE(prds.uom,'') as uom,

          COALESCE(prds.is_featured,0) as is_featured,
          COALESCE(prds.is_best_seller,0) as is_best_seller,
          COALESCE(prds.is_free,0) as is_free,

          COALESCE(prds.price,0) as price,      
          COALESCE(prds.discount_price,0) as discount_price,   
          COALESCE(prds.reorder_point,0) as reorder_point,

          CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,  

          COALESCE((
               SELECT 
                  prod_img.path FROM )
                      product_photos as prod_img                  
                  LEFT JOIN products as prods ON prods.id = prod_img.product_id
                      WHERE prod_img.product_id = lib.product_id
                      AND prod_img.is_primary = 1    
                  LIMIT 1                                
              )
        ,'') as image_path,

        COALESCE((
               SELECT ROUND(avg(rating))
                  FROM product_reviews as rev
                WHERE rev.product_id = prds.id     
                AND rev.status = 1 
             LIMIT 1                                
              )
        ,0) as rating,

          COALESCE(prds.status,'') as status          
          
        ");    

      $query->where("lib.user_id",'=',$UserID);    
   
      if($Status!='' && $Status!='All'){

        if($Status=='Epub'){
          $query->where("prds.file_url","!=",null);    
        }

        if($Status=='Physical'){
          $query->where("prds.file_url","==",null);    
        }      
      }    
                                  
      if($SearchText != ''){
        $arSearchText = explode(" ",$SearchText);
        if(count($arSearchText) > 0){
            for($x=0; $x< count($arSearchText); $x++) {
                $query->whereraw(
                    "CONCAT_WS(' ',
                        COALESCE(prds.name,''),
                        COALESCE(prds.author,''),                        
                        COALESCE(prds.subtitle,'')
                    ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
             }
        }
    }

    if($Limit > 0){
      $query->limit($Limit);
      $query->offset(($PageNo-1) * $Limit);
    }

    $query->orderBy("prds.name","ASC");    
    $list = $query->get();
                             
     return $list;             
           
  }

 public function checkProductsIfExistInLibrary($ProductID,$CustomerID){
      
    $IsExist = false; 
    
    $list = DB::table('customer_libraries')          
        ->whereRaw('user_id=?',[$CustomerID])    
        ->whereRaw('product_id=?',[$ProductID])                                    
        ->get();

    if(count($list)>0){
        $IsExist=true;
    }else{
        $IsExist=false;
    }
    
    return $IsExist;
  }

}