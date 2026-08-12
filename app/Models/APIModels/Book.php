<?php

namespace App\Models\APIModels;

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

use App\Models\APIModels\Misc;

class Book extends Model
{
  
  // public function getBookList($data){

  //   $UserID=$data['UserID'];

  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];

  //   $query = DB::table('products as prds')
  //   ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id') 
    
  //      ->selectraw("
  //         prds.id as book_ID,

  //         COALESCE(prds.name,'') as name,
  //         COALESCE(prds.author,'') as author,
  //         COALESCE(prds.subtitle,'') as subtitle,
  //         COALESCE(prds.description,'') as  short_description,
          
  //         COALESCE(prds.slug,'') as slug,
  //         COALESCE(prds.file_url,'') as file_url,          

  //         COALESCE(prds.category_id,0) as category_id,
  //         COALESCE(prds.book_type,'') as book_type,          
      
  //         COALESCE(prds.sku,'') as sku,          
  //         COALESCE(prds.size,'') as size,
  //         COALESCE(prds.weight,'') as weight,
  //         COALESCE(prds.texture,'') as texture,
  //         COALESCE(prds.uom,'') as uom,

  //         COALESCE(prds.is_featured,0) as is_featured,
  //         COALESCE(prds.is_best_seller,0) as is_best_seller,
  //         COALESCE(prds.is_free,0) as is_free,
  //         COALESCE(prds.is_premium,0) as is_premium,

  //         COALESCE(prds.ebook_price,0) as price,   
  //         COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
  //         COALESCE(prds.reorder_point,0) as reorder_point, 
  //         COALESCE(prds.read_count,0) as read_count,   

  //         CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

  //         COALESCE((
  //              SELECT 
  //                 prod_img.path FROM 
  //                     product_photos as prod_img                  
  //                 LEFT JOIN products as prods ON prods.id = prod_img.product_id
  //                     WHERE prod_img.product_id = prds.id     
  //                     AND prod_img.is_primary = 1    
  //                 LIMIT 1                                
  //             )
  //       ,'') as image_path,

  //       COALESCE((
  //             SELECT ROUND(avg(rating))
  //                 FROM product_reviews as rev
  //               WHERE rev.product_id = prds.id     
  //               AND rev.status = 1 
  //            LIMIT 1                                
  //             )
  //       ,0) as rating,

  //       COALESCE((
  //              SELECT 
  //                 promo.discount FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL                     
  //                 LIMIT 1                                
  //             )
  //       ,0) as promo_discount_percent,

  //       COALESCE((
  //              SELECT 
  //                  (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id 
  //                      AND promo.applicable_product_type !='physical'                                              
  //                      AND promo.status = 'ACTIVE'
  //                      AND promo_prods.deleted_at IS NULL LIMIT 1                                
  //             )
  //       ,0) as promo_discount_price,

  //       COALESCE((
  //          SELECT 
  //              bkmrk.chapter_no FROM 
  //                   book_marks as bkmrk                  
  //               LEFT JOIN products as prods ON prods.id = bkmrk.product_id
  //                    WHERE bkmrk.product_id = prds.id    
  //                    AND bkmrk.customer_id=".$UserID." 
  //                    LIMIT 1                                
  //         )
  //     ,'') as chapter_no,

  //     COALESCE((
  //              SELECT 
  //                 cust_lib.product_id FROM 
  //               customer_libraries as cust_lib                                    
  //                     WHERE cust_lib.product_id = prds.id 
  //                     AND cust_lib.user_id=".$UserID." LIMIT 1                                
  //             )
  //       ,0) as product_library_exist,


  //       COALESCE(prds.status,'') as status          
          
  //       ");    

  //     $query->where("prds.file_url","!=",null); 
  //     $query->where("prds.status","=",'PUBLISHED');    
  //     $query->where("prds.deleted_at","=",null); 
        
  //     if($Status!='' && $Status!='All'){

  //         if($Status=='Featured'){
  //           $query->where("prds.is_featured","=",1);    
  //         }  

  //         if($Status=='Premium'){
  //           $query->where("prds.is_premium","=",1);    
  //           $query->where("prds.is_free","=",0);        
  //         } 

  //         if($Status=='Best Seller'){
  //           $query->where("prds.is_best_seller","=",1);
  //           $query->where("prds.is_free","=",0);        
  //         } 

  //         if($Status=='Free'){
  //           $query->where("prds.is_free","=",1);    
  //         } 

  //         if($Status=='New Release'){
  //           $query->where("prds.created_at","!=",null);    
  //         }
  //     }     
                                     
  //     if($SearchText != ''){
  //       $arSearchText = explode(" ",$SearchText);
  //       if(count($arSearchText) > 0){
  //           for($x=0; $x< count($arSearchText); $x++) {
  //               $query->whereraw(
  //                   "CONCAT_WS(' ',
  //                       COALESCE(prds.name,''),
  //                       COALESCE(prds.author,''),                        
  //                       COALESCE(prds.subtitle,''),
  //                       COALESCE(prds.book_type,''),
  //                       COALESCE(prod_cat.name,'')
  //                   ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
  //            }
  //       }
  //   }

  //   if($Limit > 0){
  //     $query->limit($Limit);
  //     $query->offset(($PageNo-1) * $Limit);
  //   }

  //   $query->orderBy("prds.created_at","ASC");    
  //    $list = $query->limit(10)->get();  // get temp 10
                             
  //    return $list;             
           
  // }

    public function getBookList($data){

    $UserID     = (int)$data['UserID'];
    $Status     = $data['Status'];
    $SearchText = $data['SearchText'];
    $Limit      = $data['Limit'];
    $PageNo     = $data['PageNo'];

    $query = DB::table('products as prds')
        ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')

        // PRIMARY IMAGE — collapsed to exactly one photo row per product before joining
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING — aggregated, one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — aggregated, one row per product (also merges old duplicate discount% / discount_price subqueries)
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        // BOOKMARK — one row per product for this customer
        ->leftJoin(DB::raw("(
            SELECT product_id, MAX(chapter_no) as chapter_no
            FROM book_marks
            WHERE customer_id = ".$UserID."
            GROUP BY product_id
        ) as bkmrk"), 'bkmrk.product_id', '=', 'prds.id')

        // LIBRARY — one row per product for this user (existence check only)
        ->leftJoin(DB::raw("(
            SELECT DISTINCT product_id
            FROM customer_libraries
            WHERE user_id = ".$UserID."
        ) as lib"), 'lib.product_id', '=', 'prds.id')

        ->selectRaw("
            prds.id as book_ID,

            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,

            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,

            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(bkmrk.chapter_no,'') as chapter_no,

            CASE WHEN lib.product_id IS NOT NULL THEN 1 ELSE 0 END as product_library_exist,

            COALESCE(prds.status,'') as status
        ")

        ->whereNotNull('prds.file_url')
        ->where('prds.status', '=', 'PUBLISHED')
        ->whereNull('prds.deleted_at');

       if ($Status != '' && $Status != 'All') {

        if ($Status == 'Featured') {
            $query->where('prds.is_featured', '=', 1);
        }

        if ($Status == 'Premium') {
            $query->where('prds.is_premium', '=', 1)
                  ->where('prds.is_free', '=', 0);
        }

        if ($Status == 'Best Seller') {
            $query->where('prds.is_best_seller', '=', 1)
                  ->where('prds.is_free', '=', 0);
        }

        if ($Status == 'Free') {
            $query->where('prds.is_free', '=', 1);
        }

        if ($Status == 'New Release') {
            $query->whereNotNull('prds.created_at');
        }
    }

    if ($SearchText != '') {
        $arSearchText = array_filter(explode(" ", trim($SearchText)));
        foreach ($arSearchText as $word) {
            $query->where(function($q) use ($word) {
                $like = '%'.str_replace(['%','_'], ['\%','\_'], $word).'%';
                $q->where('prds.name', 'like', $like)
                  ->orWhere('prds.author', 'like', $like)
                  ->orWhere('prds.subtitle', 'like', $like)
                  ->orWhere('prds.book_type', 'like', $like)
                  ->orWhere('prod_cat.name', 'like', $like);
            });
        }
    }

    $query->orderBy('prds.created_at', 'ASC');

    // if ($Limit > 0) {
    //     $query->limit($Limit)->offset(($PageNo - 1) * $Limit);
    // } else {
    //     $query->limit(10);
    // }
   
    $query->limit(10);

    return $query->get();
  }

  // public function getRandomBookList($data){

  //   $UserID=$data['UserID'];

  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];

  //   $query = DB::table('products as prds')
  //   ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id') 
    
  //      ->selectraw("
  //         prds.id as book_ID,

  //         COALESCE(prds.name,'') as name,
  //         COALESCE(prds.author,'') as author,
  //         COALESCE(prds.subtitle,'') as subtitle,
  //         COALESCE(prds.description,'') as  short_description,
          
  //         COALESCE(prds.slug,'') as slug,
  //         COALESCE(prds.file_url,'') as file_url,          

  //         COALESCE(prds.category_id,0) as category_id,
  //         COALESCE(prds.book_type,'') as book_type,          
      
  //         COALESCE(prds.sku,'') as sku,          
  //         COALESCE(prds.size,'') as size,
  //         COALESCE(prds.weight,'') as weight,
  //         COALESCE(prds.texture,'') as texture,
  //         COALESCE(prds.uom,'') as uom,

  //         COALESCE(prds.is_featured,0) as is_featured,
  //         COALESCE(prds.is_best_seller,0) as is_best_seller,
  //         COALESCE(prds.is_free,0) as is_free,
  //         COALESCE(prds.is_premium,0) as is_premium,

  //         COALESCE(prds.ebook_price,0) as price,   
  //         COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
  //         COALESCE(prds.reorder_point,0) as reorder_point,  
  //         COALESCE(prds.read_count,0) as read_count,  

  //         CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

  //         COALESCE((
  //              SELECT 
  //                 prod_img.path FROM 
  //                     product_photos as prod_img                  
  //                 LEFT JOIN products as prods ON prods.id = prod_img.product_id
  //                     WHERE prod_img.product_id = prds.id     
  //                     AND prod_img.is_primary = 1                        
  //             )
  //       ,'') as image_path,

  //       COALESCE((
  //             SELECT ROUND(avg(rating))
  //                 FROM product_reviews as rev
  //               WHERE rev.product_id = prds.id     
  //               AND rev.status = 1                
  //             )
  //       ,0) as rating,

  //       COALESCE((
  //              SELECT 
  //                 promo.discount FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL                              
  //             )
  //       ,0) as promo_discount_percent,

  //       COALESCE((
  //              SELECT 
  //                  (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id 
  //                      AND promo.applicable_product_type !='physical'                                              
  //                      AND promo.status = 'ACTIVE'
  //                      AND promo_prods.deleted_at IS NULL                                
  //             )
  //       ,0) as promo_discount_price,
        
  //       COALESCE((
  //          SELECT 
  //              bkmrk.chapter_no FROM 
  //                   book_marks as bkmrk                  
  //               LEFT JOIN products as prods ON prods.id = bkmrk.product_id
  //                    WHERE bkmrk.product_id = prds.id    
  //                    AND bkmrk.customer_id=".$UserID." 
  //                    LIMIT 1                                
  //         )
  //     ,'') as chapter_no,

  //     COALESCE((
  //              SELECT 
  //                 cust_lib.product_id FROM 
  //               customer_libraries as cust_lib                                    
  //                     WHERE cust_lib.product_id = prds.id 
  //                     AND cust_lib.user_id=".$UserID." LIMIT 1                                
  //             )
  //       ,0) as product_library_exist,


  //       COALESCE(prds.status,'') as status          
          
  //       ");    

  //     $query->where("prds.file_url","!=",null); 
  //     $query->where("prds.status","=",'PUBLISHED');    
  //     $query->where("prds.deleted_at","=",null); 
        
  //    $query->orderByRaw('RAND()');
  //    //$query->take(10);

  //    $list = $query->limit(10)->get();  // get temp 10
                  
  //     return $list;             
           
  // }


public function getRandomBookList($data){

    $UserID = (int)$data['UserID'];
    $Limit  = isset($data['Limit']) && $data['Limit'] > 0 ? (int)$data['Limit'] : 10;

    // STEP 1: pull only eligible IDs — cheap, narrow, indexed scan
    $eligibleIds = DB::table('products')
        ->whereNotNull('file_url')
        ->where('status', 'PUBLISHED')
        ->whereNull('deleted_at')
        ->pluck('id');

    if ($eligibleIds->isEmpty()) {
        return collect();
    }

    // STEP 2: pick random IDs in PHP — no full-table sort in MySQL
    $randomIds = $eligibleIds
        ->random(min($Limit, $eligibleIds->count()))
        ->toArray();

    // STEP 3: run the full detail query, filtered to just those IDs
    $query = DB::table('products as prds')
        ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')

        // PRIMARY IMAGE — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — one row per product, reused for both % and price
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        // BOOKMARK — one row per product for this customer
        ->leftJoin(DB::raw("(
            SELECT product_id, MAX(chapter_no) as chapter_no
            FROM book_marks
            WHERE customer_id = ".$UserID."
            GROUP BY product_id
        ) as bkmrk"), 'bkmrk.product_id', '=', 'prds.id')

        // LIBRARY — one row per product for this user
        ->leftJoin(DB::raw("(
            SELECT DISTINCT product_id
            FROM customer_libraries
            WHERE user_id = ".$UserID."
        ) as lib"), 'lib.product_id', '=', 'prds.id')

        ->whereIn('prds.id', $randomIds)

        ->selectRaw("
            prds.id as book_ID,

            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,

            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,

            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(bkmrk.chapter_no,'') as chapter_no,

            CASE WHEN lib.product_id IS NOT NULL THEN 1 ELSE 0 END as product_library_exist,

            COALESCE(prds.status,'') as status
        ");
    
    $query->limit(10);
    $list = $query->get();
    
    return $list;
 }

  // public function getContinueToReadBookList($data){

  //   $UserID=$data['UserID'];
  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];

  //     $query = DB::table('continue_to_read_book as cont')  
  //     ->join('products as prds', 'prds.id', '=', 'cont.product_id')   

  //      ->selectraw("
  //         prds.id as book_ID,

  //         COALESCE(prds.name,'') as name,
  //         COALESCE(prds.author,'') as author,
  //         COALESCE(prds.subtitle,'') as subtitle,
  //         COALESCE(prds.description,'') as  short_description,
          
  //         COALESCE(prds.slug,'') as slug,
  //         COALESCE(prds.file_url,'') as file_url,          

  //         COALESCE(prds.category_id,0) as category_id,
  //         COALESCE(prds.book_type,'') as book_type,          
      
  //         COALESCE(prds.sku,'') as sku,          
  //         COALESCE(prds.size,'') as size,
  //         COALESCE(prds.weight,'') as weight,
  //         COALESCE(prds.texture,'') as texture,
  //         COALESCE(prds.uom,'') as uom,

  //         COALESCE(prds.is_featured,0) as is_featured,
  //         COALESCE(prds.is_best_seller,0) as is_best_seller,
  //         COALESCE(prds.is_free,0) as is_free,
  //         COALESCE(prds.is_premium,0) as is_premium,

  //         COALESCE(prds.ebook_price,0) as price,   
  //         COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
  //         COALESCE(prds.reorder_point,0) as reorder_point,  
  //         COALESCE(prds.read_count,0) as read_count,  

  //         CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

  //         COALESCE((
  //              SELECT 
  //                 prod_img.path FROM 
  //                     product_photos as prod_img                  
  //                 LEFT JOIN products as prods ON prods.id = prod_img.product_id
  //                     WHERE prod_img.product_id = prds.id     
  //                     AND prod_img.is_primary = 1                        
  //             )
  //       ,'') as image_path,

  //       COALESCE((
  //             SELECT ROUND(avg(rating))
  //                 FROM product_reviews as rev
  //               WHERE rev.product_id = prds.id     
  //               AND rev.status = 1                
  //             )
  //       ,0) as rating,

  //       COALESCE((
  //              SELECT 
  //                 promo.discount FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL                              
  //             )
  //       ,0) as promo_discount_percent,

  //       COALESCE((
  //              SELECT 
  //                  (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id 
  //                      AND promo.applicable_product_type !='physical'                                              
  //                      AND promo.status = 'ACTIVE'
  //                      AND promo_prods.deleted_at IS NULL                                
  //             )
  //       ,0) as promo_discount_price,
        
  //       COALESCE((
  //          SELECT 
  //              bkmrk.chapter_no FROM 
  //                   book_marks as bkmrk                  
  //               LEFT JOIN products as prods ON prods.id = bkmrk.product_id
  //                    WHERE bkmrk.product_id = prds.id    
  //                    AND bkmrk.customer_id=".$UserID." 
  //                    LIMIT 1                                
  //         )
  //     ,'') as chapter_no,

  //      COALESCE((
  //              SELECT 
  //                 cust_lib.product_id FROM 
  //               customer_libraries as cust_lib                                    
  //                     WHERE cust_lib.product_id = prds.id 
  //                     AND cust_lib.user_id=".$UserID." LIMIT 1                                
  //             )
  //       ,0) as product_library_exist,



  //       COALESCE(prds.status,'') as status          
          
  //       ");    
  
  //     $query->where("prds.deleted_at","=",null);
  //     $query->whereRaw("cont.customer_id =?",[$UserID]); 
  //     $query->orderBy("cont.created_at","DESC");   
         
  //     $list = $query->limit(10)->get();  // get temp 10
                           
  //    return $list;           
           
  // }

public function getContinueToReadBookList($data){

    $UserID     = (int)$data['UserID'];
    $Status     = $data['Status'];
    $SearchText = $data['SearchText'];
    $Limit      = $data['Limit'];
    $PageNo     = $data['PageNo'];

    $query = DB::table('continue_to_read_book as cont')
        ->join('products as prds', 'prds.id', '=', 'cont.product_id')

        // PRIMARY IMAGE — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — one row per product, reused for both % and price
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        // BOOKMARK — one row per product for this customer
        ->leftJoin(DB::raw("(
            SELECT product_id, MAX(chapter_no) as chapter_no
            FROM book_marks
            WHERE customer_id = ".$UserID."
            GROUP BY product_id
        ) as bkmrk"), 'bkmrk.product_id', '=', 'prds.id')

        // LIBRARY — one row per product for this user
        ->leftJoin(DB::raw("(
            SELECT DISTINCT product_id
            FROM customer_libraries
            WHERE user_id = ".$UserID."
        ) as lib"), 'lib.product_id', '=', 'prds.id')

        ->selectRaw("
            prds.id as book_ID,

            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,

            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,

            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(bkmrk.chapter_no,'') as chapter_no,

            CASE WHEN lib.product_id IS NOT NULL THEN 1 ELSE 0 END as product_library_exist,

            COALESCE(prds.status,'') as status
        ")

        ->whereNull('prds.deleted_at')
        ->where('cont.customer_id', '=', $UserID);

    $query->orderBy('cont.created_at', 'DESC');

    // if ($Limit > 0) {
    //     $query->limit($Limit)->offset(($PageNo - 1) * $Limit);
    // } else {
    //     $query->limit(10);
    // }
   
   $query->limit(10);
    return $query->get();
}

  // public function getSearchBookList($data){

  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];

  //   $UserID=$data['UserID'];

  //   $Filter_Sort=$data['Filter_Sort'];
  //   $Filter_Genre=$data['Filter_Genre'];
  //   $Filter_Star=$data['Filter_Star'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];

  //   $query = DB::table('products as prds')
  //   ->leftjoin('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id') 
    
  //      ->selectraw("
  //         prds.id as book_ID,

  //         COALESCE(prds.name,'') as name,
  //         COALESCE(prds.author,'') as author,
  //         COALESCE(prds.subtitle,'') as subtitle,
  //         COALESCE(prds.description,'') as  short_description,
          
  //         COALESCE(prds.slug,'') as slug,
  //         COALESCE(prds.file_url,'') as file_url,          

  //         COALESCE(prds.category_id,0) as category_id,
  //         COALESCE(prds.book_type,'') as book_type,          
      
  //         COALESCE(prds.sku,'') as sku,          
  //         COALESCE(prds.size,'') as size,
  //         COALESCE(prds.weight,'') as weight,
  //         COALESCE(prds.texture,'') as texture,
  //         COALESCE(prds.uom,'') as uom,

  //         COALESCE(prds.is_featured,0) as is_featured,
  //         COALESCE(prds.is_best_seller,0) as is_best_seller,
  //         COALESCE(prds.is_free,0) as is_free,
  //         COALESCE(prds.is_premium,0) as is_premium,

  //         COALESCE(prds.ebook_price,0) as price,   
  //         COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
  //         COALESCE(prds.reorder_point,0) as reorder_point,  
  //         COALESCE(prds.read_count,0) as read_count,  

  //         CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

  //         COALESCE((
  //              SELECT 
  //                 prod_img.path FROM 
  //                     product_photos as prod_img                  
  //                 LEFT JOIN products as prods ON prods.id = prod_img.product_id
  //                     WHERE prod_img.product_id = prds.id     
  //                     AND prod_img.is_primary = 1 LIMIT 1                                
  //             )
  //       ,'') as image_path,

  //       COALESCE((
  //              SELECT ROUND(avg(rating))
  //                 FROM product_reviews as rev
  //               WHERE rev.product_id = prds.id     
  //               AND rev.status = 1 LIMIT 1                                
  //             )
  //       ,0) as rating,

  //       COALESCE((
  //              SELECT 
  //                 promo.discount FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL LIMIT 1                                
  //             )
  //       ,0) as promo_discount_percent,

  //         COALESCE((
  //              SELECT 
  //                  (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL LIMIT 1                                
  //             )
  //       ,0) as promo_discount_price,

  //        COALESCE((
  //          SELECT 
  //              bkmrk.chapter_no FROM 
  //                   book_marks as bkmrk                  
  //               LEFT JOIN products as prods ON prods.id = bkmrk.product_id
  //                    WHERE bkmrk.product_id = prds.id    
  //                    AND bkmrk.customer_id=".$UserID." 
  //                    LIMIT 1                                
  //         )
  //     ,'') as chapter_no,

  //        COALESCE((
  //              SELECT 
  //                 cust_lib.product_id FROM 
  //               customer_libraries as cust_lib                                    
  //                     WHERE cust_lib.product_id = prds.id 
  //                     AND cust_lib.user_id=".$UserID." LIMIT 1                                
  //             )
  //       ,0) as product_library_exist,


  //       COALESCE(prds.status,'') as status          
          
  //       ");    

  //     $query->where("prds.file_url","!=",null); 
  //     $query->where("prds.status","=",'PUBLISHED');    
  //     $query->where("prds.deleted_at","=",null); 
        
  //     if($Status!='' && $Status!='All'){

  //         if($Status=='Featured'){
  //           $query->where("prds.is_featured","=",1);    
  //         }  

  //         if($Status=='Premium'){
  //           $query->where("prds.is_premium","=",1);    
  //           $query->where("prds.is_free","=",0);        
  //         } 

  //         if($Status=='Best Seller'){
  //           $query->where("prds.is_best_seller","=",1);
  //           $query->where("prds.is_free","=",0);        
  //         } 

  //         if($Status=='Free'){
  //           $query->where("prds.is_free","=",1);    
  //         } 

  //         if($Status=='New Release'){
  //           $query->where("prds.created_at","!=",null);    
  //         }
  //     }    
       
  //     //Filter By Star Rating
  //     if($Filter_Star!=''){
  //        if($Filter_Star=='5'){             
  //          $query->whereRaw("
  //             COALESCE((
  //              SELECT AVG(rating)
  //                 FROM product_reviews as rev
  //                   WHERE rev.product_id = prds.id     
  //                   AND rev.status = 1 
  //                 LIMIT 1                                
  //               )
  //             ,0)=5
  //         ");
  //       }

  //       if($Filter_Star=='4'){
  //                $query->whereRaw("
  //             COALESCE((
  //              SELECT AVG(rating)
  //                 FROM product_reviews as rev
  //                   WHERE rev.product_id = prds.id     
  //                   AND rev.status = 1 
  //                 LIMIT 1                                
  //               )
  //             ,0)=4
  //         ");
  //       }

  //        if($Filter_Star=='3'){
  //                $query->whereRaw("
  //             COALESCE((
  //              SELECT AVG(rating)
  //                 FROM product_reviews as rev
  //                   WHERE rev.product_id = prds.id     
  //                   AND rev.status = 1 
  //                 LIMIT 1                                
  //               )
  //             ,0)=3
  //         ");
  //       }

  //       if($Filter_Star=='2'){
  //                $query->whereRaw("
  //             COALESCE((
  //              SELECT AVG(rating)
  //                 FROM product_reviews as rev
  //                   WHERE rev.product_id = prds.id     
  //                   AND rev.status = 1 
  //                 LIMIT 1                                
  //               )
  //             ,0)=2
  //         ");
  //       }

  //       if($Filter_Star=='1'){
  //                $query->whereRaw("
  //             COALESCE((
  //              SELECT AVG(rating)
  //                 FROM product_reviews as rev
  //                   WHERE rev.product_id = prds.id     
  //                   AND rev.status = 1 
  //                 LIMIT 1                                
  //               )
  //             ,0)=1
  //         ");
  //       }
  //    }  

  //    //Filter By Genre Category
  //     if($Filter_Genre!='' && $Filter_Genre>0){
  //        $query->where("prds.category_id","=",$Filter_Genre);   
  //     }
                                  
  //     if($SearchText != ''){
  //       $arSearchText = explode(" ",$SearchText);
  //       if(count($arSearchText) > 0){
  //           for($x=0; $x< count($arSearchText); $x++) {
  //               $query->whereraw(
  //                   "CONCAT_WS(' ',
  //                       COALESCE(prds.name,''),
  //                       COALESCE(prds.author,''),                        
  //                       COALESCE(prds.subtitle,''),
  //                       COALESCE(prds.book_type,''),
  //                       COALESCE(prod_cat.name,'')
  //                   ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
  //            }
  //       }
  //   }

  //   // if($Limit > 0){
  //   //   $query->limit($Limit);
  //   //   $query->offset(($PageNo-1) * $Limit);
  //   // }
   
  //   //Sorting Option
  //   if($Filter_Sort!=''){
  //     if($Filter_Sort=='Featured Books'){
  //       $query->orderBy("prds.is_featured","DESC");   
  //      }
  //      if($Filter_Sort=='Price: Low-High'){
  //       $query->orderBy("prds.ebook_price","ASC");   
  //      }
  //       if($Filter_Sort=='Price: High-Low'){
  //       $query->orderBy("prds.ebook_price","DESC");   
  //      }
  //      if($Filter_Sort=='Publication Date'){
  //       $query->orderBy("prds.publication_date","ASC");   
  //      }
  //       if($Filter_Sort=='Title A-Z Sort'){
  //       $query->orderBy("prds.name","ASC");   
  //      }
  //       if($Filter_Sort=='Title Z-A Sort'){
  //       $query->orderBy("prds.name","DESC");   
  //      }
  //      if($Filter_Sort=='Author A-Z Sort'){
  //       $query->orderBy("prds.author","ASC");   
  //      }
  //       if($Filter_Sort=='Author Z-A Sort'){
  //       $query->orderBy("prds.author","DESC");   
  //      }
  //    }
  //   else{
  //       $query->orderBy("prds.created_at","ASC");   
  //   }  
    

  //   $list = $query->limit(10)->get();  // get temp 10
                             
  //    return $list;             
           
  // }


public function getSearchBookList($data){

    $Status      = $data['Status'];
    $SearchText  = $data['SearchText'];
    $UserID      = (int)$data['UserID'];

    $Filter_Sort  = $data['Filter_Sort'];
    $Filter_Genre = $data['Filter_Genre'];
    $Filter_Star  = $data['Filter_Star'];

    $Limit  = $data['Limit'];
    $PageNo = $data['PageNo'];

    $query = DB::table('products as prds')
        ->leftJoin('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')

        // PRIMARY IMAGE — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING — one row per product. Reused for both the SELECT and the star filter below,
        // instead of the original which repeated this subquery 6 separate times.
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as avg_rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — one row per product, reused for both % and price
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        // BOOKMARK — one row per product for this customer
        ->leftJoin(DB::raw("(
            SELECT product_id, MAX(chapter_no) as chapter_no
            FROM book_marks
            WHERE customer_id = ".$UserID."
            GROUP BY product_id
        ) as bkmrk"), 'bkmrk.product_id', '=', 'prds.id')

        // LIBRARY — one row per product for this user
        ->leftJoin(DB::raw("(
            SELECT DISTINCT product_id
            FROM customer_libraries
            WHERE user_id = ".$UserID."
        ) as lib"), 'lib.product_id', '=', 'prds.id')

        ->selectRaw("
            prds.id as book_ID,

            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,

            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,

            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.avg_rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(bkmrk.chapter_no,'') as chapter_no,

            CASE WHEN lib.product_id IS NOT NULL THEN 1 ELSE 0 END as product_library_exist,

            COALESCE(prds.status,'') as status
        ")

        ->whereNotNull('prds.file_url')
        ->where('prds.status', '=', 'PUBLISHED')
        ->whereNull('prds.deleted_at');

    if ($Status != '' && $Status != 'All') {

        if ($Status == 'Featured') {
            $query->where('prds.is_featured', '=', 1);
        }

        if ($Status == 'Premium') {
            $query->where('prds.is_premium', '=', 1)
                  ->where('prds.is_free', '=', 0);
        }

        if ($Status == 'Best Seller') {
            $query->where('prds.is_best_seller', '=', 1)
                  ->where('prds.is_free', '=', 0);
        }

        if ($Status == 'Free') {
            $query->where('prds.is_free', '=', 1);
        }

        if ($Status == 'New Release') {
            $query->whereNotNull('prds.created_at');
        }
    }

    // STAR FILTER — was 5 near-identical correlated subqueries (one per branch, each
    // recomputing AVG(rating) again on top of the one already in SELECT). Now a single
    // condition against the already-joined rev.avg_rating — computed once, reused everywhere.
    if ($Filter_Star != '' && in_array($Filter_Star, ['1','2','3','4','5'])) {
        $query->whereRaw('COALESCE(rev.avg_rating, 0) = ?', [(int)$Filter_Star]);
    }

    // GENRE FILTER
    if ($Filter_Genre != '' && $Filter_Genre > 0) {
        $query->where('prds.category_id', '=', $Filter_Genre);
    }

    if ($SearchText != '') {
        $arSearchText = array_filter(explode(" ", trim($SearchText)));
        foreach ($arSearchText as $word) {
            $query->where(function($q) use ($word) {
                $like = '%'.str_replace(['%','_'], ['\%','\_'], $word).'%';
                $q->where('prds.name', 'like', $like)
                  ->orWhere('prds.author', 'like', $like)
                  ->orWhere('prds.subtitle', 'like', $like)
                  ->orWhere('prds.book_type', 'like', $like)
                  ->orWhere('prod_cat.name', 'like', $like);
            });
        }
    }

    // SORTING
    if ($Filter_Sort != '') {
        if ($Filter_Sort == 'Featured Books') {
            $query->orderBy('prds.is_featured', 'DESC');
        }
        if ($Filter_Sort == 'Price: Low-High') {
            $query->orderBy('prds.ebook_price', 'ASC');
        }
        if ($Filter_Sort == 'Price: High-Low') {
            $query->orderBy('prds.ebook_price', 'DESC');
        }
        if ($Filter_Sort == 'Publication Date') {
            $query->orderBy('prds.publication_date', 'ASC');
        }
        if ($Filter_Sort == 'Title A-Z Sort') {
            $query->orderBy('prds.name', 'ASC');
        }
        if ($Filter_Sort == 'Title Z-A Sort') {
            $query->orderBy('prds.name', 'DESC');
        }
        if ($Filter_Sort == 'Author A-Z Sort') {
            $query->orderBy('prds.author', 'ASC');
        }
        if ($Filter_Sort == 'Author Z-A Sort') {
            $query->orderBy('prds.author', 'DESC');
        }
    } else {
        $query->orderBy('prds.created_at', 'ASC');
    }

    // // real pagination restored — original had this commented out and hardcoded limit(10) instead
    // if ($Limit > 0) {
    //     $query->limit($Limit)->offset(($PageNo - 1) * $Limit);
    // } else {
    //     $query->limit(10);
    // }
  
    $query->limit(10);
    return $query->get();
}

  // public function getSearchAudioBookList($data){

  //   $UserID=$data['UserID'];

  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];

  //   $query = DB::table('products as prds')
  //   ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id') 
    
  //      ->selectraw("
  //         prds.id as book_ID,

  //         COALESCE(prds.name,'') as name,
  //         COALESCE(prds.author,'') as author,
  //         COALESCE(prds.subtitle,'') as subtitle,
  //         COALESCE(prds.description,'') as  short_description,
          
  //         COALESCE(prds.slug,'') as slug,
  //         COALESCE(prds.file_url,'') as file_url,          

  //         COALESCE(prds.category_id,0) as category_id,
  //         COALESCE(prds.book_type,'') as book_type,          
      
  //         COALESCE(prds.sku,'') as sku,          
  //         COALESCE(prds.size,'') as size,
  //         COALESCE(prds.weight,'') as weight,
  //         COALESCE(prds.texture,'') as texture,
  //         COALESCE(prds.uom,'') as uom,

  //         COALESCE(prds.is_featured,0) as is_featured,
  //         COALESCE(prds.is_best_seller,0) as is_best_seller,
  //         COALESCE(prds.is_free,0) as is_free,
  //         COALESCE(prds.is_premium,0) as is_premium,

  //         COALESCE(prds.ebook_price,0) as price,   
  //         COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
  //         COALESCE(prds.reorder_point,0) as reorder_point, 
  //         COALESCE(prds.read_count,0) as read_count,   

  //         CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

  //         COALESCE((
  //              SELECT 
  //                 prod_img.path FROM 
  //                     product_photos as prod_img                  
  //                 LEFT JOIN products as prods ON prods.id = prod_img.product_id
  //                     WHERE prod_img.product_id = prds.id     
  //                     AND prod_img.is_primary = 1    
  //                 LIMIT 1                                
  //             )
  //       ,'') as image_path,

  //       COALESCE((
  //             SELECT ROUND(avg(rating))
  //                 FROM product_reviews as rev
  //               WHERE rev.product_id = prds.id     
  //               AND rev.status = 1 
  //            LIMIT 1                                
  //             )
  //       ,0) as rating,

  //       COALESCE((
  //              SELECT 
  //                 promo.discount FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL                     
  //                 LIMIT 1                                
  //             )
  //       ,0) as promo_discount_percent,

  //       COALESCE((
  //              SELECT 
  //                  (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id 
  //                      AND promo.applicable_product_type !='physical'                                              
  //                      AND promo.status = 'ACTIVE'
  //                      AND promo_prods.deleted_at IS NULL LIMIT 1                                
  //             )
  //       ,0) as promo_discount_price,

  //       COALESCE((
  //          SELECT 
  //              bkmrk.chapter_no FROM 
  //                   book_marks as bkmrk                  
  //               LEFT JOIN products as prods ON prods.id = bkmrk.product_id
  //                    WHERE bkmrk.product_id = prds.id    
  //                    AND bkmrk.customer_id=".$UserID." 
  //                    LIMIT 1                                
  //         )
  //     ,'') as chapter_no,

  //     COALESCE((
  //              SELECT 
  //                 cust_lib.product_id FROM 
  //               customer_libraries as cust_lib                                    
  //                     WHERE cust_lib.product_id = prds.id 
  //                     AND cust_lib.user_id=".$UserID." LIMIT 1                                
  //             )
  //       ,0) as product_library_exist,


  //       COALESCE(prds.status,'') as status          
          
  //       ");    

  //     $query->where("prds.file_url","!=",null); 
  //     $query->where("prds.status","=",'PUBLISHED');    
  //     $query->where("prds.deleted_at","=",null); 
        
  //     if($Status!='' && $Status!='All'){

  //         if($Status=='Featured'){
  //           $query->where("prds.is_featured","=",1);    
  //         }  

  //         if($Status=='Premium'){
  //           $query->where("prds.is_premium","=",1);    
  //           $query->where("prds.is_free","=",0);        
  //         } 

  //         if($Status=='Best Seller'){
  //           $query->where("prds.is_best_seller","=",1);
  //           $query->where("prds.is_free","=",0);        
  //         } 

  //         if($Status=='Free'){
  //           $query->where("prds.is_free","=",1);    
  //         } 

  //         if($Status=='New Release'){
  //           $query->where("prds.created_at","!=",null);    
  //         }
  //     }     
                                     
  //     if($SearchText != ''){
  //       $arSearchText = explode(" ",$SearchText);
  //       if(count($arSearchText) > 0){
  //           for($x=0; $x< count($arSearchText); $x++) {
  //               $query->whereraw(
  //                   "CONCAT_WS(' ',
  //                       COALESCE(prds.name,''),
  //                       COALESCE(prds.author,''),                        
  //                       COALESCE(prds.subtitle,''),
  //                       COALESCE(prds.book_type,''),
  //                       COALESCE(prod_cat.name,''),
  //                       COALESCE(prds.description,'')
  //                   ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
  //            }
  //       }
  //   }

  //   // if($Limit > 0){
  //   //   $query->limit($Limit);
  //   //   $query->offset(($PageNo-1) * $Limit);
  //   // }

  //   $query->orderBy("prds.created_at","ASC");    
  //    $list = $query->limit(10)->get();  // get temp 10
                             
  //    return $list;             
           
  // }

 public function getSearchAudioBookList($data){

    $UserID     = (int)$data['UserID'];
    $Status     = $data['Status'];
    $SearchText = $data['SearchText'];
    $Limit      = $data['Limit'];
    $PageNo     = $data['PageNo'];

    $query = DB::table('products as prds')
        ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')

        // PRIMARY IMAGE — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — one row per product, reused for both % and price
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        // BOOKMARK — one row per product for this customer
        ->leftJoin(DB::raw("(
            SELECT product_id, MAX(chapter_no) as chapter_no
            FROM book_marks
            WHERE customer_id = ".$UserID."
            GROUP BY product_id
        ) as bkmrk"), 'bkmrk.product_id', '=', 'prds.id')

        // LIBRARY — one row per product for this user
        ->leftJoin(DB::raw("(
            SELECT DISTINCT product_id
            FROM customer_libraries
            WHERE user_id = ".$UserID."
        ) as lib"), 'lib.product_id', '=', 'prds.id')

        ->selectRaw("
            prds.id as book_ID,

            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,

            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,

            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(bkmrk.chapter_no,'') as chapter_no,

            CASE WHEN lib.product_id IS NOT NULL THEN 1 ELSE 0 END as product_library_exist,

            COALESCE(prds.status,'') as status
        ")

        ->whereNotNull('prds.file_url')
        ->where('prds.status', '=', 'PUBLISHED')
        ->whereNull('prds.deleted_at');

    if ($Status != '' && $Status != 'All') {

        if ($Status == 'Featured') {
            $query->where('prds.is_featured', '=', 1);
        }

        if ($Status == 'Premium') {
            $query->where('prds.is_premium', '=', 1)
                  ->where('prds.is_free', '=', 0);
        }

        if ($Status == 'Best Seller') {
            $query->where('prds.is_best_seller', '=', 1)
                  ->where('prds.is_free', '=', 0);
        }

        if ($Status == 'Free') {
            $query->where('prds.is_free', '=', 1);
        }

        if ($Status == 'New Release') {
            $query->whereNotNull('prds.created_at');
        }
    }

    // search includes description — same as your original for this function specifically
    if ($SearchText != '') {
        $arSearchText = array_filter(explode(" ", trim($SearchText)));
        foreach ($arSearchText as $word) {
            $query->where(function($q) use ($word) {
                $like = '%'.str_replace(['%','_'], ['\%','\_'], $word).'%';
                $q->where('prds.name', 'like', $like)
                  ->orWhere('prds.author', 'like', $like)
                  ->orWhere('prds.subtitle', 'like', $like)
                  ->orWhere('prds.book_type', 'like', $like)
                  ->orWhere('prod_cat.name', 'like', $like)
                  ->orWhere('prds.description', 'like', $like);
            });
        }
    }

    $query->orderBy('prds.created_at', 'ASC');

    // // real pagination restored — original had this commented out and hardcoded limit(10)
    // if ($Limit > 0) {
    //     $query->limit($Limit)->offset(($PageNo - 1) * $Limit);
    // } else {
    //     $query->limit(10);
    // }
   
    $query->limit(10);
    return $query->get();
}

  // public function getBookInfoByID($BookID){


  //   $query = DB::table('products as prds')
    
  //      ->selectraw("
  //         prds.id as book_ID,

  //         COALESCE(prds.name,'') as name,
  //         COALESCE(prds.author,'') as author,
  //         COALESCE(prds.subtitle,'') as subtitle,
  //         COALESCE(prds.description,'') as  short_description,
          
  //         COALESCE(prds.slug,'') as slug,
  //         COALESCE(prds.file_url,'') as file_url,          

  //         COALESCE(prds.category_id,0) as category_id,
  //         COALESCE(prds.book_type,'') as book_type,          
      
  //         COALESCE(prds.sku,'') as sku,          
  //         COALESCE(prds.size,'') as size,
  //         COALESCE(prds.weight,'') as weight,
  //         COALESCE(prds.texture,'') as texture,
  //         COALESCE(prds.uom,'') as uom,

  //         COALESCE(prds.is_featured,0) as is_featured,
  //         COALESCE(prds.is_best_seller,0) as is_best_seller,
  //         COALESCE(prds.is_free,0) as is_free,
  //         COALESCE(prds.is_premium,0) as is_premium,

  //         COALESCE(prds.ebook_price,0) as price,   
  //         COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
  //         COALESCE(prds.reorder_point,0) as reorder_point,  
  //         COALESCE(prds.read_count,0) as read_count,  

  //         CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

  //         COALESCE((
  //              SELECT 
  //                 prod_img.path FROM 
  //                     product_photos as prod_img                  
  //                 LEFT JOIN products as prods ON prods.id = prod_img.product_id
  //                     WHERE prod_img.product_id = prds.id     
  //                     AND prod_img.is_primary = 1 LIMIT 1                                
  //             )
  //       ,'') as image_path,

  //        COALESCE((
  //            SELECT ROUND(avg(rating))
  //                 FROM product_reviews as rev
  //               WHERE rev.product_id = prds.id     
  //               AND rev.status = 1 LIMIT 1                                
  //             )
  //       ,0) as rating,

  //       COALESCE((
  //              SELECT 
  //                 promo.discount FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                     
  //                      AND promo_prods.deleted_at IS NULL LIMIT 1                                
  //             )
  //       ,0) as promo_discount_percent,

  //       COALESCE((
  //              SELECT 
  //                  (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
  //                       promos as promo                  
  //                 LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
  //                      WHERE promo_prods.product_id = prds.id  
  //                      AND promo.applicable_product_type !='physical'
  //                      AND promo.status = 'ACTIVE'                    
  //                      AND promo_prods.deleted_at IS NULL LIMIT 1                                
  //             )
  //       ,0) as promo_discount_price,

  //         COALESCE(prds.status,'') as status          
          
  //       ");    

  //     $query->where("prds.id","=",$BookID); 
  //     $query->where("prds.file_url","!=",null);    
      
      
  //   $info = $query->first();
                             
  //    return $info;             
           
  // }
  

  public function getBookInfoByID($BookID){

    $BookID = (int)$BookID; // was raw-concatenated, now cast — closes SQL injection risk

    $query = DB::table('products as prds')

        // PRIMARY IMAGE — MIN(id) guards against a product having 2+ primary photos,
        // which would otherwise throw "Subquery returns more than 1 row" or duplicate this row
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — merged the duplicate discount% / discount_price subqueries into one join
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        ->selectRaw("
            prds.id as book_ID,
            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,
            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,
            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(prds.status,'') as status
        ")

        ->where('prds.id', '=', $BookID)
        ->whereNotNull('prds.file_url');

    return $query->first();
}

 // BOOK CATEGORY
  public function getAllBookCatergoryList(){

      $query = DB::table('product_categories as prod_cat')    

       ->selectraw("
          prod_cat.id as category_ID,

          COALESCE(prod_cat.name,'') as CategoryName,
          COALESCE(prod_cat.mobile_file_url,'') as CategoryIcon,
          COALESCE(prod_cat.slug,'') as slug,       

          COALESCE(prod_cat.created_at,'') as created_at,
          COALESCE(prod_cat.status,'') as status
        ");

       $query->where("prod_cat.deleted_at","=",null); 
       $query->where("prod_cat.status","=","PUBLISHED"); 
         
      $list = $query->get();
                             
     return $list;  

  }

 //HEADER CATALOGUE 
  public function getHeaderCatalogueList(){

      $query = DB::table('product_catalog_headers as prod_hdrs_cat')    

       ->selectraw("
          prod_hdrs_cat.id  as prod_hdrs_cat_ID,

          COALESCE(prod_hdrs_cat.name,'') as CatalogueName,          
          COALESCE(prod_hdrs_cat.status,'') as status
        ");

       $query->where("prod_hdrs_cat.status","=",1); 
         
      $list = $query->limit(10)->get(); // get temp 10
                             
     return $list;  

  }

 // CATALOGUE DETAILS
 // public function getDetailsCatalogueList($data){

 //      $HeaderID=$data['HeaderID'];
 //      $UserID=$data['UserID'];

 //      $query = DB::table('product_catalog_details as prod_det_cat')  
 //      ->join('product_catalog_headers as prod_hdrs_cat', 'prod_hdrs_cat.id', '=', 'prod_det_cat.product_catalog_header_id')   
 //      ->join('products as prds', 'prds.id', '=', 'prod_det_cat.product_id')   

 //       ->selectraw("    
 //          prod_hdrs_cat.name  as header_name,

 //          prds.id as book_ID,

 //          COALESCE(prds.name,'') as name,
 //          COALESCE(prds.author,'') as author,
 //          COALESCE(prds.subtitle,'') as subtitle,
 //          COALESCE(prds.description,'') as  short_description,
          
 //          COALESCE(prds.slug,'') as slug,
 //          COALESCE(prds.file_url,'') as file_url,          

 //          COALESCE(prds.category_id,0) as category_id,
 //          COALESCE(prds.book_type,'') as book_type,          
      
 //          COALESCE(prds.sku,'') as sku,          
 //          COALESCE(prds.size,'') as size,
 //          COALESCE(prds.weight,'') as weight,
 //          COALESCE(prds.texture,'') as texture,
 //          COALESCE(prds.uom,'') as uom,

 //          COALESCE(prds.is_featured,0) as is_featured,
 //          COALESCE(prds.is_best_seller,0) as is_best_seller,
 //          COALESCE(prds.is_free,0) as is_free,
 //          COALESCE(prds.is_premium,0) as is_premium,

 //          COALESCE(prds.ebook_price,0) as price,   
 //          COALESCE(prds.ebook_discount_price,0) as discount_price,      
          
 //          COALESCE(prds.reorder_point,0) as reorder_point,  
 //          COALESCE(prds.read_count,0) as read_count,  

 //          CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

 //          COALESCE((
 //               SELECT 
 //                  prod_img.path FROM 
 //                      product_photos as prod_img                  
 //                  LEFT JOIN products as prods ON prods.id = prod_img.product_id
 //                      WHERE prod_img.product_id = prod_det_cat.product_id   
 //                      AND prod_img.is_primary = 1 LIMIT 1                                
 //              )
 //        ,'') as image_path,

 //         COALESCE((
 //             SELECT ROUND(avg(rating))
 //                  FROM product_reviews as rev
 //                WHERE rev.product_id = prod_det_cat.product_id   
 //                AND rev.status = 1 LIMIT 1                                
 //              )
 //        ,0) as rating,

 //        COALESCE((
 //               SELECT 
 //                  promo.discount FROM 
 //                        promos as promo                  
 //                  LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
 //                       WHERE promo_prods.product_id = prod_det_cat.product_id  
 //                       AND promo.applicable_product_type !='physical'
 //                       AND promo.status = 'ACTIVE'                     
 //                       AND promo_prods.deleted_at IS NULL LIMIT 1                                
 //              )
 //        ,0) as promo_discount_percent,

 //        COALESCE((
 //               SELECT 
 //                   (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
 //                        promos as promo                  
 //                  LEFT JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
 //                       WHERE promo_prods.product_id = prod_det_cat.product_id  
 //                       AND promo.applicable_product_type !='physical'
 //                       AND promo.status = 'ACTIVE'                     
 //                       AND promo_prods.deleted_at IS NULL LIMIT 1                                
 //              )
 //        ,0) as promo_discount_price,

 //         COALESCE((
 //           SELECT 
 //               bkmrk.chapter_no FROM 
 //                    book_marks as bkmrk                  
 //                LEFT JOIN products as prods ON prods.id = bkmrk.product_id
 //                     WHERE bkmrk.product_id = prds.id    
 //                     AND bkmrk.customer_id=".$UserID." 
 //                     LIMIT 1                                
 //          )
 //      ,'') as chapter_no,

 //         COALESCE((
 //               SELECT 
 //                  cust_lib.product_id FROM 
 //                customer_libraries as cust_lib                                    
 //                      WHERE cust_lib.product_id = prds.id 
 //                      AND cust_lib.user_id=".$UserID." LIMIT 1                                
 //              )
 //        ,0) as product_library_exist,


 //          COALESCE(prds.status,'') as status        

 //        ");

 //       $query->where("prds.deleted_at","=",null);
 //       $query->whereRaw("prod_det_cat.product_catalog_header_id =?",[$HeaderID]); 
         
 //     $list = $query->limit(10)->get();  // get temp 10
                             
 //     return $list;  

 //  }
 

 public function getDetailsCatalogueList($data){

    $HeaderID = (int)$data['HeaderID'];
    $UserID   = (int)$data['UserID'];

    $query = DB::table('product_catalog_details as prod_det_cat')
        ->join('product_catalog_headers as prod_hdrs_cat', 'prod_hdrs_cat.id', '=', 'prod_det_cat.product_catalog_header_id')
        ->join('products as prds', 'prds.id', '=', 'prod_det_cat.product_id')

        // PRIMARY IMAGE — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, MIN(id) as photo_id
            FROM product_photos
            WHERE is_primary = 1
            GROUP BY product_id
        ) as prod_img_pick"), 'prod_img_pick.product_id', '=', 'prds.id')
        ->leftJoin('product_photos as prod_img', 'prod_img.id', '=', 'prod_img_pick.photo_id')

        // RATING — one row per product
        ->leftJoin(DB::raw("(
            SELECT product_id, ROUND(AVG(rating)) as rating
            FROM product_reviews
            WHERE status = 1
            GROUP BY product_id
        ) as rev"), 'rev.product_id', '=', 'prds.id')

        // PROMO — one row per product, reused for both % and price
        ->leftJoin(DB::raw("(
            SELECT pp.product_id, MIN(promo.discount) as discount
            FROM promo_products as pp
            INNER JOIN promos as promo ON promo.id = pp.promo_id
            WHERE promo.applicable_product_type != 'physical'
              AND promo.status = 'ACTIVE'
              AND pp.deleted_at IS NULL
            GROUP BY pp.product_id
        ) as promo"), 'promo.product_id', '=', 'prds.id')

        // BOOKMARK — one row per product for this customer
        ->leftJoin(DB::raw("(
            SELECT product_id, MAX(chapter_no) as chapter_no
            FROM book_marks
            WHERE customer_id = ".$UserID."
            GROUP BY product_id
        ) as bkmrk"), 'bkmrk.product_id', '=', 'prds.id')

        // LIBRARY — one row per product for this user
        ->leftJoin(DB::raw("(
            SELECT DISTINCT product_id
            FROM customer_libraries
            WHERE user_id = ".$UserID."
        ) as lib"), 'lib.product_id', '=', 'prds.id')

        ->selectRaw("
            prod_hdrs_cat.name as header_name,

            prds.id as book_ID,

            COALESCE(prds.name,'') as name,
            COALESCE(prds.author,'') as author,
            COALESCE(prds.subtitle,'') as subtitle,
            COALESCE(prds.description,'') as short_description,

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
            COALESCE(prds.is_premium,0) as is_premium,

            COALESCE(prds.ebook_price,0) as price,
            COALESCE(prds.ebook_discount_price,0) as discount_price,

            COALESCE(prds.reorder_point,0) as reorder_point,
            COALESCE(prds.read_count,0) as read_count,

            CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

            COALESCE(prod_img.path,'') as image_path,

            COALESCE(rev.rating,0) as rating,

            COALESCE(promo.discount,0) as promo_discount_percent,

            COALESCE(prds.ebook_price - (promo.discount/100 * prds.ebook_price), 0) as promo_discount_price,

            COALESCE(bkmrk.chapter_no,'') as chapter_no,

            CASE WHEN lib.product_id IS NOT NULL THEN 1 ELSE 0 END as product_library_exist,

            COALESCE(prds.status,'') as status
        ")

        ->whereNull('prds.deleted_at')
        ->where('prod_det_cat.product_catalog_header_id', '=', $HeaderID);

    return $query->limit(10)->get();
}

  public function setBookAsReported($data){

    $UserID=$data['UserID'];    
    $ProductID=$data['ProductID'];   

     DB::table('products')
        ->where('id',$ProductID)
        ->update([                                                       
          'is_reported' => 1,
       ]);

       return 'Success';   
           
  }

   public function saveBookMarks($data){

    $TODAY = date("Y-m-d H:i:s");
    
    $UserID=$data['UserID'];    
    $ProductID=$data['ProductID'];    
    $PageNo=$data['PageNo'];   

    $info = DB::table('book_marks')          
        ->whereRaw('customer_id=?',[$UserID])    
        ->whereRaw('product_id=?',[$ProductID])          
        ->first();

    if(isset($info)>0){

      DB::table('book_marks')
        ->where('customer_id',$UserID)
        ->where('product_id',$ProductID)
        ->update([                                                       
          'chapter_no' => $PageNo,
          'created_at' => $TODAY     
       ]);   
           
    }else{

     $BookMarkID = DB::table('book_marks')
        ->insertGetId([                                            
          'customer_id' => $UserID,              
          'product_id' => $ProductID,                                            
          'chapter_no' => $PageNo,                                                                                                                  
          'created_at' => $TODAY             
        ]);

    }
  }

  public function saveReadBookCount($data){

    $ProductID=$data['ProductID'];        

    $read_count=1;     

    $book_info = DB::table('products')          
          ->where('id',$ProductID) 
          ->first();

        if(isset($book_info)>0){
            $read_count=$book_info->read_count+1;
            DB::table('products')
                ->where('id',$ProductID)
                ->update([                                                       
                  'read_count' => $read_count  
               ]);
       }          
  }

 public function saveContinueReadBook($data){
   
    $TODAY = date("Y-m-d H:i:s");

    $ProductID=$data['ProductID'];   
    $UserID=$data['UserID'];         

    $book_info = DB::table('continue_to_read_book')          
          ->where('product_id',$ProductID) 
          ->where('customer_id',$UserID) 
          ->first();

    if(isset($book_info)>0){
         DB::table('continue_to_read_book')
            ->where('product_id',$ProductID)
            ->where('customer_id',$UserID)
            ->update([                                                       
              'created_at' => $TODAY  
           ]);
      }else{
        $BookID = DB::table('continue_to_read_book')
            ->insertGetId([                                            
              'customer_id' => $UserID,              
              'product_id' => $ProductID,                                                                                                                                                          
              'created_at' => $TODAY             
            ]); 
      }
  }

  public function getReadBookCount($data){

    $ProductID=$data['ProductID'];        

    $read_count=0;     

    $book_info = DB::table('products')          
          ->where('id',$ProductID) 
          ->first();

    if(isset($book_info)>0){
        $read_count=$book_info->read_count;
    }    

    return $read_count;      
  }

  public function getPageChapterBookMark($data){
      
    $ChapterPageNo = ""; 
    $ChapterPageDate = "";
    $ResultChapter="";

    $UserID=$data['UserID'];
    $ProductID=$data['ProductID'];
    
    $info = DB::table('book_marks')          
        ->whereRaw('customer_id=?',[$UserID])    
        ->whereRaw('product_id=?',[$ProductID])                                          
        ->first();

        if(isset($info)>0){
            $ChapterPageNo =$info->chapter_no; 
            $ChapterPageDate = date('m/d/Y', strtotime($info->created_at));
             
            $ResultChapter=$ChapterPageNo.' - '.$ChapterPageDate;
        }

    return $ResultChapter;
        

    }

  public function saveSearchBooks($data){
   
    $TODAY = date("Y-m-d H:i:s");

    $ProductID=$data['ProductID'];   
    $UserID=$data['UserID'];         

    $book_info = DB::table('searched_book')          
          ->where('product_id',$ProductID) 
          ->where('customer_id',$UserID) 
          ->first();

    if(isset($book_info)>0){
         DB::table('searched_book')
            ->where('product_id',$ProductID)
            ->where('customer_id',$UserID)
            ->update([                                                       
              'created_at' => $TODAY  
           ]);
      }else{

        $BookID = DB::table('searched_book')
            ->insertGetId([                                            
              'customer_id' => $UserID,              
              'product_id' => $ProductID,                                                                                                                                                          
              'created_at' => $TODAY             
            ]); 
      }
  }


}