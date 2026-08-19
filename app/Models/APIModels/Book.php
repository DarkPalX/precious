<?php

namespace App\Models\APIModels;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use Session;
use Hash;
use View;
use Input;
use Image;

use App\Models\APIModels\Misc;

class Book extends Model
{

    public function getBookList($data){

    $Status=$data['Status'];
    $SearchText=$data['SearchText'];
    $Limit=$data['Limit'];
    $PageNo=$data['PageNo'];
    $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

    $CacheKey = 'book_list_' . $UserID . '_' . md5($Status . '|' . $SearchText . '|' . $Limit . '|' . $PageNo);

    $list = Cache::remember($CacheKey, now()->addSeconds(40), function () use ($UserID, $Status, $SearchText, $Limit, $PageNo) {

        $query = DB::table('products as prds')
            ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')
            ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_active_promo as promo', 'promo.product_id', '=', 'prds.id')

            ->leftJoin('vw_customer_bookmarks as bm', function ($join) use ($UserID) {
                $join->on('bm.product_id', '=', 'prds.id')
                     ->where('bm.customer_id', '=', $UserID);
            })
            ->leftJoin('vw_customer_library as cl', function ($join) use ($UserID) {
                $join->on('cl.product_id', '=', 'prds.id')
                     ->where('cl.user_id', '=', $UserID);
            })
            ->selectraw("
                prds.id AS book_ID,

                COALESCE(prds.name, '') AS name,
                COALESCE(prds.author, '') AS author,
                COALESCE(prds.subtitle, '') AS subtitle,
                COALESCE(prds.description, '') AS short_description,

                COALESCE(prds.slug, '') AS slug,
                COALESCE(prds.file_url, '') AS file_url,

                COALESCE(prds.category_id, 0) AS category_id,
                COALESCE(prds.book_type, '') AS book_type,

                COALESCE(prds.sku, '') AS sku,
                COALESCE(prds.size, '') AS size,
                COALESCE(prds.weight, '') AS weight,
                COALESCE(prds.texture, '') AS texture,
                COALESCE(prds.uom, '') AS uom,

                COALESCE(prds.is_featured, 0) AS is_featured,
                COALESCE(prds.is_best_seller, 0) AS is_best_seller,
                COALESCE(prds.is_free, 0) AS is_free,
                COALESCE(prds.is_premium, 0) AS is_premium,

                COALESCE(prds.ebook_price, 0) AS price,
                COALESCE(prds.ebook_discount_price, 0) AS discount_price,

                COALESCE(prds.reorder_point, 0) AS reorder_point,
                COALESCE(prds.read_count, 0) AS read_count,

                CONCAT(
                    COALESCE(prds.name, ''), ' ',
                    COALESCE(prds.author, ''), '',
                    COALESCE(prds.book_type, ''), '',
                    COALESCE(prds.subtitle, '')
                ) AS search_fields,

                COALESCE(img.image_path, '') AS image_path,
                COALESCE(rt.rating, 0) AS rating,
                COALESCE(promo.promo_discount_percent, 0) AS promo_discount_percent,
                COALESCE(
                    prds.ebook_price - (promo.promo_discount_percent / 100 * prds.ebook_price),
                    0
                ) AS promo_discount_price,

                COALESCE(bm.chapter_no, '') AS chapter_no,
                COALESCE(cl.product_id, 0) AS product_library_exist,

                COALESCE(prds.status, '') AS status
            ");

        $query->whereNotNull("prds.file_url");
        $query->where("prds.status", "=", 'PUBLISHED');
        $query->whereNull("prds.deleted_at");

        if($Status!='' && $Status!='All'){

            if($Status=='Featured'){
                $query->where("prds.is_featured","=",1);
            }

            if($Status=='Premium'){
                $query->where("prds.is_premium","=",1);
                $query->where("prds.is_free","=",0);
            }

            if($Status=='Best Seller'){
                $query->where("prds.is_best_seller","=",1);
                $query->where("prds.is_free","=",0);
            }

            if($Status=='Free'){
                $query->where("prds.is_free","=",1);
            }

            if($Status=='New Release'){
                $query->whereNotNull("prds.created_at");
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
                            COALESCE(prds.subtitle,''),
                            COALESCE(prds.book_type,''),
                            COALESCE(prod_cat.name,'')
                        ) like ?", ['%'.$arSearchText[$x].'%']
                    );
                }
            }
        }

        if($Limit > 0){
            $query->limit($Limit);
            $query->offset(($PageNo-1) * $Limit);
        }

        $query->orderBy("prds.created_at","ASC");
        return $query->limit(60)->get();  // get temp 10
    });

    return $list;
}

  
//   public function getBookList($data){

//    // $UserID=$data['UserID'];

//     $Status=$data['Status'];
//     $SearchText=$data['SearchText'];

//     $Limit=$data['Limit'];
//     $PageNo=$data['PageNo'];

//     $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

//     $CacheKey = 'book_list_' . $UserID . '_' . md5($Status . '|' . $SearchText . '|' . $Limit . '|' . $PageNo);

//     $list = Cache::remember($CacheKey, now()->addSeconds(40), function () use ($UserID, $Status, $SearchText, $Limit, $PageNo) {

//         $query = DB::table('products as prds')
//         ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')

//            ->selectraw("
//                prds.id AS book_ID,

//                 COALESCE(prds.name, '') AS name,
//                 COALESCE(prds.author, '') AS author,
//                 COALESCE(prds.subtitle, '') AS subtitle,
//                 COALESCE(prds.description, '') AS short_description,

//                 COALESCE(prds.slug, '') AS slug,
//                 COALESCE(prds.file_url, '') AS file_url,

//                 COALESCE(prds.category_id, 0) AS category_id,
//                 COALESCE(prds.book_type, '') AS book_type,

//                 COALESCE(prds.sku, '') AS sku,
//                 COALESCE(prds.size, '') AS size,
//                 COALESCE(prds.weight, '') AS weight,
//                 COALESCE(prds.texture, '') AS texture,
//                 COALESCE(prds.uom, '') AS uom,

//                 COALESCE(prds.is_featured, 0) AS is_featured,
//                 COALESCE(prds.is_best_seller, 0) AS is_best_seller,
//                 COALESCE(prds.is_free, 0) AS is_free,
//                 COALESCE(prds.is_premium, 0) AS is_premium,

//                 COALESCE(prds.ebook_price, 0) AS price,
//                 COALESCE(prds.ebook_discount_price, 0) AS discount_price,

//                 COALESCE(prds.reorder_point, 0) AS reorder_point,
//                 COALESCE(prds.read_count, 0) AS read_count,

//                 CONCAT(
//                     COALESCE(prds.name, ''),
//                     ' ',
//                     COALESCE(prds.author, ''),
//                     '',
//                     COALESCE(prds.book_type, ''),
//                     '',
//                     COALESCE(prds.subtitle, '')
//                 ) AS search_fields,


//                 COALESCE(
//                     (
//                         SELECT prod_img.path
//                           FROM product_photos AS prod_img
//                         WHERE prod_img.product_id = prds.id
//                           AND prod_img.is_primary = 1
//                         LIMIT 1
//                     ),
//                     ''
//                 ) AS image_path,


//                 COALESCE(
//                     (
//                         SELECT ROUND(AVG(rev.rating))
//                         FROM product_reviews AS rev
//                         WHERE rev.product_id = prds.id
//                           AND rev.status = 1
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS rating,


//                 COALESCE(
//                     (
//                         SELECT promo.discount
//                             FROM promos AS promo
//                         INNER JOIN promo_products AS promo_prods
//                             ON promo_prods.promo_id = promo.id
//                         WHERE promo_prods.product_id = prds.id
//                           AND promo.applicable_product_type != 'physical'
//                           AND promo.status = 'ACTIVE'
//                           AND promo_prods.deleted_at IS NULL
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS promo_discount_percent,

//                 COALESCE(
//                     (
//                         SELECT
//                             prds.ebook_price -
//                             (
//                                 promo.discount / 100 * prds.ebook_price
//                             )
//                         FROM promos AS promo
//                         INNER JOIN promo_products AS promo_prods
//                             ON promo_prods.promo_id = promo.id
//                         WHERE promo_prods.product_id = prds.id
//                           AND promo.applicable_product_type != 'physical'
//                           AND promo.status = 'ACTIVE'
//                           AND promo_prods.deleted_at IS NULL
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS promo_discount_price,


//                 COALESCE(
//                     (
//                         SELECT bkmrk.chapter_no
//                             FROM book_marks AS bkmrk
//                         WHERE bkmrk.product_id = prds.id
//                           AND bkmrk.customer_id= ?
//                         LIMIT 1
//                     ),
//                     ''
//                 ) AS chapter_no,


//                 COALESCE(
//                     (
//                         SELECT cust_lib.product_id
//                         FROM customer_libraries AS cust_lib
//                         WHERE cust_lib.product_id = prds.id
//                           AND cust_lib.user_id= ? 
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS product_library_exist,

//                 COALESCE(prds.status, '') AS status          

//           ", [$UserID, $UserID]);

//           $query->where("prds.file_url","!=",null);
//           $query->where("prds.status","=",'PUBLISHED');
//           $query->where("prds.deleted_at","=",null);

//           if($Status!='' && $Status!='All'){

//               if($Status=='Featured'){
//                 $query->where("prds.is_featured","=",1);
//               }

//               if($Status=='Premium'){
//                 $query->where("prds.is_premium","=",1);
//                 $query->where("prds.is_free","=",0);
//               }

//               if($Status=='Best Seller'){
//                 $query->where("prds.is_best_seller","=",1);
//                 $query->where("prds.is_free","=",0);
//               }

//               if($Status=='Free'){
//                 $query->where("prds.is_free","=",1);
//               }

//               if($Status=='New Release'){
//                 $query->where("prds.created_at","!=",null);
//               }
//           }

//           if($SearchText != ''){
//             $arSearchText = explode(" ",$SearchText);
//             if(count($arSearchText) > 0){
//                 for($x=0; $x< count($arSearchText); $x++) {
//                     $query->whereraw(
//                         "CONCAT_WS(' ',
//                             COALESCE(prds.name,''),
//                             COALESCE(prds.author,''),
//                             COALESCE(prds.subtitle,''),
//                             COALESCE(prds.book_type,''),
//                             COALESCE(prod_cat.name,'')
//                         ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
//                  }
//             }
//         }

//         if($Limit > 0){
//           $query->limit($Limit);
//           $query->offset(($PageNo-1) * $Limit);
//         }

//          $query->orderBy("prds.created_at","ASC");
//          return $query->limit(20)->get();  // get temp 10
//     });

//     return $list;

// }


public function getContinueToReadBookList($data){

    $Status=$data['Status'];
    $SearchText=$data['SearchText'];
    $Limit=$data['Limit'];
    $PageNo=$data['PageNo'];

    $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

    $CacheKey = 'continue_to_read_' . $UserID;

    $list = Cache::remember($CacheKey, now()->addSeconds(30), function () use ($UserID) {

        $query = DB::table('continue_to_read_book as cont')
            ->join('products as prds', 'prds.id', '=', 'cont.product_id')
            ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_active_promo as promo', 'promo.product_id', '=', 'prds.id')
            ->leftJoin('vw_customer_bookmarks as bm', function ($join) use ($UserID) {
                $join->on('bm.product_id', '=', 'prds.id')
                     ->where('bm.customer_id', '=', $UserID);
            })
            ->leftJoin('vw_customer_library as cl', function ($join) use ($UserID) {
                $join->on('cl.product_id', '=', 'prds.id')
                     ->where('cl.user_id', '=', $UserID);
            })
            ->selectraw("
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

                CONCAT(
                    COALESCE(prds.name, ''), ' ',
                    COALESCE(prds.author, ''), '',
                    COALESCE(prds.book_type, ''), '',
                    COALESCE(prds.subtitle, '')
                ) AS search_fields,

                COALESCE(img.image_path, '') AS image_path,
                COALESCE(rt.rating, 0) AS rating,
                COALESCE(promo.promo_discount_percent, 0) AS promo_discount_percent,
                COALESCE(
                    prds.ebook_price - (promo.promo_discount_percent / 100 * prds.ebook_price),
                    0
                ) AS promo_discount_price,

                COALESCE(bm.chapter_no, '') AS chapter_no,
                COALESCE(cl.product_id, 0) AS product_library_exist,

                COALESCE(prds.status, '') AS status
            ");

        $query->whereNull("prds.deleted_at");
        $query->whereRaw("cont.customer_id = ?", [$UserID]);
        $query->orderBy("cont.created_at", "DESC");

        return $query->limit(10)->get();  // get temp 10
    });

    return $list;
}

// public function getContinueToReadBookList($data){

//     //$UserID=$data['UserID'];

//     $Status=$data['Status'];
//     $SearchText=$data['SearchText'];

//     $Limit=$data['Limit'];
//     $PageNo=$data['PageNo'];

//     $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

//     $CacheKey = 'continue_to_read_' . $UserID;

//     $list = Cache::remember($CacheKey, now()->addSeconds(30), function () use ($UserID) {

//           $query = DB::table('continue_to_read_book as cont')
//           ->join('products as prds', 'prds.id', '=', 'cont.product_id')

//            ->selectraw("
//               prds.id as book_ID,

//               COALESCE(prds.name,'') as name,
//               COALESCE(prds.author,'') as author,
//               COALESCE(prds.subtitle,'') as subtitle,
//               COALESCE(prds.description,'') as  short_description,

//               COALESCE(prds.slug,'') as slug,
//               COALESCE(prds.file_url,'') as file_url,

//               COALESCE(prds.category_id,0) as category_id,
//               COALESCE(prds.book_type,'') as book_type,

//               COALESCE(prds.sku,'') as sku,
//               COALESCE(prds.size,'') as size,
//               COALESCE(prds.weight,'') as weight,
//               COALESCE(prds.texture,'') as texture,
//               COALESCE(prds.uom,'') as uom,

//               COALESCE(prds.is_featured,0) as is_featured,
//               COALESCE(prds.is_best_seller,0) as is_best_seller,
//               COALESCE(prds.is_free,0) as is_free,
//               COALESCE(prds.is_premium,0) as is_premium,

//               COALESCE(prds.ebook_price,0) as price,
//               COALESCE(prds.ebook_discount_price,0) as discount_price,

//               COALESCE(prds.reorder_point,0) as reorder_point,
//               COALESCE(prds.read_count,0) as read_count,

//               CONCAT(
//                     COALESCE(prds.name, ''),
//                     ' ',
//                     COALESCE(prds.author, ''),
//                     '',
//                     COALESCE(prds.book_type, ''),
//                     '',
//                     COALESCE(prds.subtitle, '')
//                 ) AS search_fields,


//                 COALESCE(
//                     (
//                         SELECT prod_img.path
//                           FROM product_photos AS prod_img
//                         WHERE prod_img.product_id = prds.id
//                           AND prod_img.is_primary = 1
//                         LIMIT 1
//                     ),
//                     ''
//                 ) AS image_path,


//               COALESCE(
//                     (
//                         SELECT ROUND(AVG(rev.rating))
//                         FROM product_reviews AS rev
//                         WHERE rev.product_id = prds.id
//                           AND rev.status = 1
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS rating,


//                 COALESCE(
//                     (
//                         SELECT promo.discount
//                             FROM promos AS promo
//                         INNER JOIN promo_products AS promo_prods
//                             ON promo_prods.promo_id = promo.id
//                         WHERE promo_prods.product_id = prds.id
//                           AND promo.applicable_product_type != 'physical'
//                           AND promo.status = 'ACTIVE'
//                           AND promo_prods.deleted_at IS NULL
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS promo_discount_percent,

//                 COALESCE(
//                     (
//                         SELECT
//                             prds.ebook_price -
//                             (
//                                 promo.discount / 100 * prds.ebook_price
//                             )
//                         FROM promos AS promo
//                         INNER JOIN promo_products AS promo_prods
//                             ON promo_prods.promo_id = promo.id
//                         WHERE promo_prods.product_id = prds.id
//                           AND promo.applicable_product_type != 'physical'
//                           AND promo.status = 'ACTIVE'
//                           AND promo_prods.deleted_at IS NULL
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS promo_discount_price,


//                 COALESCE(
//                     (
//                         SELECT bkmrk.chapter_no
//                             FROM book_marks AS bkmrk
//                         WHERE bkmrk.product_id = prds.id
//                           AND bkmrk.customer_id= ?
//                         LIMIT 1
//                     ),
//                     ''
//                 ) AS chapter_no,


//                 COALESCE(
//                     (
//                         SELECT cust_lib.product_id
//                         FROM customer_libraries AS cust_lib
//                         WHERE cust_lib.product_id = prds.id
//                           AND cust_lib.user_id= ?
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS product_library_exist,

//                 COALESCE(prds.status, '') AS status

//           ", [$UserID, $UserID]);

//           $query->where("prds.deleted_at","=",null);
//           $query->whereRaw("cont.customer_id =?",[$UserID]);
//           $query->orderBy("cont.created_at","DESC");

//           return $query->limit(10)->get();  // get temp 10
//     });

//     return $list;

// }


public function getSearchBookList($data){

    $Status=$data['Status'];
    $SearchText=$data['SearchText'];

    $Filter_Sort=$data['Filter_Sort'];
    $Filter_Genre=$data['Filter_Genre'];
    $Filter_Star=$data['Filter_Star'];

    $Limit=$data['Limit'];
    $PageNo=$data['PageNo'];

    $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

    $CacheKey = 'search_book_list_' . $UserID . '_' . md5(
        $Status . '|' . $SearchText . '|' . $Filter_Sort . '|' . $Filter_Genre . '|' . $Filter_Star
    );

    $list = Cache::remember($CacheKey, now()->addSeconds(40), function () use ($UserID, $Status, $SearchText, $Filter_Sort, $Filter_Genre, $Filter_Star) {

        $query = DB::table('products as prds')
            ->leftJoin('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')
            ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_active_promo as promo', 'promo.product_id', '=', 'prds.id')
            ->leftJoin('vw_customer_bookmarks as bm', function ($join) use ($UserID) {
                $join->on('bm.product_id', '=', 'prds.id')
                     ->where('bm.customer_id', '=', $UserID);
            })
            ->leftJoin('vw_customer_library as cl', function ($join) use ($UserID) {
                $join->on('cl.product_id', '=', 'prds.id')
                     ->where('cl.user_id', '=', $UserID);
            })
            ->selectraw("
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

                CONCAT(
                    COALESCE(prds.name, ''), ' ',
                    COALESCE(prds.author, ''), '',
                    COALESCE(prds.book_type, ''), '',
                    COALESCE(prds.subtitle, '')
                ) AS search_fields,

                COALESCE(img.image_path, '') AS image_path,
                COALESCE(rt.rating, 0) AS rating,
                COALESCE(promo.promo_discount_percent, 0) AS promo_discount_percent,
                COALESCE(
                    prds.ebook_price - (promo.promo_discount_percent / 100 * prds.ebook_price),
                    0
                ) AS promo_discount_price,

                COALESCE(bm.chapter_no, '') AS chapter_no,
                COALESCE(cl.product_id, 0) AS product_library_exist,

                COALESCE(prds.status, '') AS status
            ");

        $query->whereNotNull("prds.file_url");
        $query->where("prds.status", "=", 'PUBLISHED');
        $query->whereNull("prds.deleted_at");

        if($Status!='' && $Status!='All'){

            if($Status=='Featured'){
                $query->where("prds.is_featured","=",1);
            }

            if($Status=='Premium'){
                $query->where("prds.is_premium","=",1);
                $query->where("prds.is_free","=",0);
            }

            if($Status=='Best Seller'){
                $query->where("prds.is_best_seller","=",1);
                $query->where("prds.is_free","=",0);
            }

            if($Status=='Free'){
                $query->where("prds.is_free","=",1);
            }

            if($Status=='New Release'){
                $query->whereNotNull("prds.created_at");
            }
        }

        // Filter By Star Rating — now uses vw_product_rating instead of a repeated correlated subquery
        if($Filter_Star!='' && in_array($Filter_Star, ['1','2','3','4','5'])){
            $query->where("rt.rating", "=", (int)$Filter_Star);
        }

        // Filter By Genre Category
        if($Filter_Genre!='' && $Filter_Genre>0){
            $query->where("prds.category_id","=",$Filter_Genre);
        }

        if($SearchText != ''){
            $arSearchText = explode(" ",$SearchText);
            if(count($arSearchText) > 0){
                for($x=0; $x< count($arSearchText); $x++) {
                    $query->whereraw(
                        "CONCAT_WS(' ',
                            COALESCE(prds.name,''),
                            COALESCE(prds.author,''),
                            COALESCE(prds.subtitle,''),
                            COALESCE(prds.book_type,''),
                            COALESCE(prod_cat.name,'')
                        ) like ?", ['%'.$arSearchText[$x].'%']
                    );
                }
            }
        }

        // Sorting Option
        if($Filter_Sort!=''){
            if($Filter_Sort=='Featured Books'){
                $query->orderBy("prds.is_featured","DESC");
            }
            if($Filter_Sort=='Price: Low-High'){
                $query->orderBy("prds.ebook_price","ASC");
            }
            if($Filter_Sort=='Price: High-Low'){
                $query->orderBy("prds.ebook_price","DESC");
            }
            if($Filter_Sort=='Publication Date'){
                $query->orderBy("prds.publication_date","ASC");
            }
            if($Filter_Sort=='Title A-Z Sort'){
                $query->orderBy("prds.name","ASC");
            }
            if($Filter_Sort=='Title Z-A Sort'){
                $query->orderBy("prds.name","DESC");
            }
            if($Filter_Sort=='Author A-Z Sort'){
                $query->orderBy("prds.author","ASC");
            }
            if($Filter_Sort=='Author Z-A Sort'){
                $query->orderBy("prds.author","DESC");
            }
        }
        else{
            $query->orderBy("prds.created_at","ASC");
        }

        return $query->limit(60)->get();  // get temp 10
    });

    return $list;
}

// public function getSearchBookList($data){

//     $Status=$data['Status'];
//     $SearchText=$data['SearchText'];

//     //$UserID=$data['UserID'];

//     $Filter_Sort=$data['Filter_Sort'];
//     $Filter_Genre=$data['Filter_Genre'];
//     $Filter_Star=$data['Filter_Star'];

//     $Limit=$data['Limit'];
//     $PageNo=$data['PageNo'];

//     $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

//     $CacheKey = 'search_book_list_' . $UserID . '_' . md5(
//         $Status . '|' . $SearchText . '|' . $Filter_Sort . '|' . $Filter_Genre . '|' . $Filter_Star
//     );

//     $list = Cache::remember($CacheKey, now()->addSeconds(40), function () use ($UserID, $Status, $SearchText, $Filter_Sort, $Filter_Genre, $Filter_Star) {

//         $query = DB::table('products as prds')
//         ->leftjoin('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')

//            ->selectraw("
//               prds.id as book_ID,

//               COALESCE(prds.name,'') as name,
//               COALESCE(prds.author,'') as author,
//               COALESCE(prds.subtitle,'') as subtitle,
//               COALESCE(prds.description,'') as  short_description,

//               COALESCE(prds.slug,'') as slug,
//               COALESCE(prds.file_url,'') as file_url,

//               COALESCE(prds.category_id,0) as category_id,
//               COALESCE(prds.book_type,'') as book_type,

//               COALESCE(prds.sku,'') as sku,
//               COALESCE(prds.size,'') as size,
//               COALESCE(prds.weight,'') as weight,
//               COALESCE(prds.texture,'') as texture,
//               COALESCE(prds.uom,'') as uom,

//               COALESCE(prds.is_featured,0) as is_featured,
//               COALESCE(prds.is_best_seller,0) as is_best_seller,
//               COALESCE(prds.is_free,0) as is_free,
//               COALESCE(prds.is_premium,0) as is_premium,

//               COALESCE(prds.ebook_price,0) as price,
//               COALESCE(prds.ebook_discount_price,0) as discount_price,

//               COALESCE(prds.reorder_point,0) as reorder_point,
//               COALESCE(prds.read_count,0) as read_count,


//               CONCAT(
//                     COALESCE(prds.name, ''),
//                     ' ',
//                     COALESCE(prds.author, ''),
//                     '',
//                     COALESCE(prds.book_type, ''),
//                     '',
//                     COALESCE(prds.subtitle, '')
//                 ) AS search_fields,


//                 COALESCE(
//                     (
//                         SELECT prod_img.path
//                           FROM product_photos AS prod_img
//                         WHERE prod_img.product_id = prds.id
//                           AND prod_img.is_primary = 1
//                         LIMIT 1
//                     ),
//                     ''
//                 ) AS image_path,


//               COALESCE(
//                     (
//                         SELECT ROUND(AVG(rev.rating))
//                         FROM product_reviews AS rev
//                         WHERE rev.product_id = prds.id
//                           AND rev.status = 1
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS rating,


//                 COALESCE(
//                     (
//                         SELECT promo.discount
//                             FROM promos AS promo
//                         INNER JOIN promo_products AS promo_prods
//                             ON promo_prods.promo_id = promo.id
//                         WHERE promo_prods.product_id = prds.id
//                           AND promo.applicable_product_type != 'physical'
//                           AND promo.status = 'ACTIVE'
//                           AND promo_prods.deleted_at IS NULL
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS promo_discount_percent,

//                 COALESCE(
//                     (
//                         SELECT
//                             prds.ebook_price -
//                             (
//                                 promo.discount / 100 * prds.ebook_price
//                             )
//                         FROM promos AS promo
//                         INNER JOIN promo_products AS promo_prods
//                             ON promo_prods.promo_id = promo.id
//                         WHERE promo_prods.product_id = prds.id
//                           AND promo.applicable_product_type != 'physical'
//                           AND promo.status = 'ACTIVE'
//                           AND promo_prods.deleted_at IS NULL
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS promo_discount_price,


//                 COALESCE(
//                     (
//                         SELECT bkmrk.chapter_no
//                             FROM book_marks AS bkmrk
//                         WHERE bkmrk.product_id = prds.id
//                           AND bkmrk.customer_id= ?
//                         LIMIT 1
//                     ),
//                     ''
//                 ) AS chapter_no,


//                 COALESCE(
//                     (
//                         SELECT cust_lib.product_id
//                         FROM customer_libraries AS cust_lib
//                         WHERE cust_lib.product_id = prds.id
//                           AND cust_lib.user_id= ?
//                         LIMIT 1
//                     ),
//                     0
//                 ) AS product_library_exist,

//                 COALESCE(prds.status, '') AS status

//             ", [$UserID, $UserID]);

//           $query->where("prds.file_url","!=",null);
//           $query->where("prds.status","=",'PUBLISHED');
//           $query->where("prds.deleted_at","=",null);

//           if($Status!='' && $Status!='All'){

//               if($Status=='Featured'){
//                 $query->where("prds.is_featured","=",1);
//               }

//               if($Status=='Premium'){
//                 $query->where("prds.is_premium","=",1);
//                 $query->where("prds.is_free","=",0);
//               }

//               if($Status=='Best Seller'){
//                 $query->where("prds.is_best_seller","=",1);
//                 $query->where("prds.is_free","=",0);
//               }

//               if($Status=='Free'){
//                 $query->where("prds.is_free","=",1);
//               }

//               if($Status=='New Release'){
//                 $query->where("prds.created_at","!=",null);
//               }
//           }

//           //Filter By Star Rating
//           if($Filter_Star!=''){
//              if($Filter_Star=='5'){
//                $query->whereRaw("
//                   COALESCE((
//                    SELECT AVG(rating)
//                       FROM product_reviews as rev
//                         WHERE rev.product_id = prds.id
//                         AND rev.status = 1
//                       LIMIT 1
//                     )
//                   ,0)=5
//               ");
//             }

//             if($Filter_Star=='4'){
//                      $query->whereRaw("
//                   COALESCE((
//                    SELECT AVG(rating)
//                       FROM product_reviews as rev
//                         WHERE rev.product_id = prds.id
//                         AND rev.status = 1
//                       LIMIT 1
//                     )
//                   ,0)=4
//               ");
//             }

//              if($Filter_Star=='3'){
//                      $query->whereRaw("
//                   COALESCE((
//                    SELECT AVG(rating)
//                       FROM product_reviews as rev
//                         WHERE rev.product_id = prds.id
//                         AND rev.status = 1
//                       LIMIT 1
//                     )
//                   ,0)=3
//               ");
//             }

//             if($Filter_Star=='2'){
//                      $query->whereRaw("
//                   COALESCE((
//                    SELECT AVG(rating)
//                       FROM product_reviews as rev
//                         WHERE rev.product_id = prds.id
//                         AND rev.status = 1
//                       LIMIT 1
//                     )
//                   ,0)=2
//               ");
//             }

//             if($Filter_Star=='1'){
//                      $query->whereRaw("
//                   COALESCE((
//                    SELECT AVG(rating)
//                       FROM product_reviews as rev
//                         WHERE rev.product_id = prds.id
//                         AND rev.status = 1
//                       LIMIT 1
//                     )
//                   ,0)=1
//               ");
//             }
//          }

//          //Filter By Genre Category
//           if($Filter_Genre!='' && $Filter_Genre>0){
//              $query->where("prds.category_id","=",$Filter_Genre);
//           }

//           if($SearchText != ''){
//             $arSearchText = explode(" ",$SearchText);
//             if(count($arSearchText) > 0){
//                 for($x=0; $x< count($arSearchText); $x++) {
//                     $query->whereraw(
//                         "CONCAT_WS(' ',
//                             COALESCE(prds.name,''),
//                             COALESCE(prds.author,''),
//                             COALESCE(prds.subtitle,''),
//                             COALESCE(prds.book_type,''),
//                             COALESCE(prod_cat.name,'')
//                         ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
//                  }
//             }
//         }

//         //Sorting Option
//         if($Filter_Sort!=''){
//           if($Filter_Sort=='Featured Books'){
//             $query->orderBy("prds.is_featured","DESC");
//            }
//            if($Filter_Sort=='Price: Low-High'){
//             $query->orderBy("prds.ebook_price","ASC");
//            }
//             if($Filter_Sort=='Price: High-Low'){
//             $query->orderBy("prds.ebook_price","DESC");
//            }
//            if($Filter_Sort=='Publication Date'){
//             $query->orderBy("prds.publication_date","ASC");
//            }
//             if($Filter_Sort=='Title A-Z Sort'){
//             $query->orderBy("prds.name","ASC");
//            }
//             if($Filter_Sort=='Title Z-A Sort'){
//             $query->orderBy("prds.name","DESC");
//            }
//            if($Filter_Sort=='Author A-Z Sort'){
//             $query->orderBy("prds.author","ASC");
//            }
//             if($Filter_Sort=='Author Z-A Sort'){
//             $query->orderBy("prds.author","DESC");
//            }
//          }
//         else{
//             $query->orderBy("prds.created_at","ASC");
//         }

//         return $query->limit(60)->get();  // get temp 10
//     });

//     return $list;

// }

public function getSearchAudioBookList($data){

    $Status=$data['Status'];
    $SearchText=$data['SearchText'];
    $Limit=$data['Limit'];
    $PageNo=$data['PageNo'];

    $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

    $CacheKey = 'search_audio_book_list_' . $UserID . '_' . md5($Status . '|' . $SearchText);

    $list = Cache::remember($CacheKey, now()->addMinutes(10), function () use ($UserID, $Status, $SearchText) {

        $query = DB::table('products as prds')
            ->join('product_categories as prod_cat', 'prod_cat.id', '=', 'prds.category_id')
            ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_active_promo as promo', 'promo.product_id', '=', 'prds.id')
            ->leftJoin('vw_customer_bookmarks as bm', function ($join) use ($UserID) {
                $join->on('bm.product_id', '=', 'prds.id')
                     ->where('bm.customer_id', '=', $UserID);
            })
            ->leftJoin('vw_customer_library as cl', function ($join) use ($UserID) {
                $join->on('cl.product_id', '=', 'prds.id')
                     ->where('cl.user_id', '=', $UserID);
            })
            ->selectraw("
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

                CONCAT(
                    COALESCE(prds.name, ''), ' ',
                    COALESCE(prds.author, ''), '',
                    COALESCE(prds.book_type, ''), '',
                    COALESCE(prds.subtitle, '')
                ) AS search_fields,

                COALESCE(img.image_path, '') AS image_path,
                COALESCE(rt.rating, 0) AS rating,
                COALESCE(promo.promo_discount_percent, 0) AS promo_discount_percent,
                COALESCE(
                    prds.ebook_price - (promo.promo_discount_percent / 100 * prds.ebook_price),
                    0
                ) AS promo_discount_price,

                COALESCE(bm.chapter_no, '') AS chapter_no,
                COALESCE(cl.product_id, 0) AS product_library_exist,

                COALESCE(prds.status, '') AS status
            ");

        $query->whereNotNull("prds.file_url");
        $query->where("prds.status", "=", 'PUBLISHED');
        $query->whereNull("prds.deleted_at");

        if($Status!='' && $Status!='All'){

            if($Status=='Featured'){
                $query->where("prds.is_featured","=",1);
            }

            if($Status=='Premium'){
                $query->where("prds.is_premium","=",1);
                $query->where("prds.is_free","=",0);
            }

            if($Status=='Best Seller'){
                $query->where("prds.is_best_seller","=",1);
                $query->where("prds.is_free","=",0);
            }

            if($Status=='Free'){
                $query->where("prds.is_free","=",1);
            }

            if($Status=='New Release'){
                $query->whereNotNull("prds.created_at");
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
                            COALESCE(prds.subtitle,''),
                            COALESCE(prds.book_type,''),
                            COALESCE(prod_cat.name,''),
                            COALESCE(prds.description,'')
                        ) like ?", ['%'.$arSearchText[$x].'%']
                    );
                }
            }
        }

        $query->orderBy("prds.created_at","ASC");
        return $query->limit(10)->get();  // get temp 10
    });

    return $list;
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

  //          CONCAT(
  //               COALESCE(prds.name, ''),
  //               ' ',
  //               COALESCE(prds.author, ''),
  //               '',
  //               COALESCE(prds.book_type, ''),
  //               '',
  //               COALESCE(prds.subtitle, '')
  //           ) AS search_fields,

  //         COALESCE(
  //               (
  //                   SELECT prod_img.path
  //                     FROM product_photos AS prod_img
  //                   WHERE prod_img.product_id = prds.id
  //                     AND prod_img.is_primary = 1
  //                   LIMIT 1
  //               ),
  //               ''
  //           ) AS image_path,

  //        COALESCE(
  //               (
  //                   SELECT ROUND(AVG(rev.rating))
  //                   FROM product_reviews AS rev
  //                   WHERE rev.product_id = prds.id
  //                     AND rev.status = 1
  //                   LIMIT 1
  //               ),
  //               0
  //       ) AS rating,

  //        COALESCE(
  //               (
  //                SELECT promo.discount
  //                       FROM promos AS promo
  //                   INNER JOIN promo_products AS promo_prods
  //                       ON promo_prods.promo_id = promo.id
  //                   WHERE promo_prods.product_id = prds.id
  //                     AND promo.applicable_product_type != 'physical'
  //                     AND promo.status = 'ACTIVE'
  //                     AND promo_prods.deleted_at IS NULL
  //                   LIMIT 1
  //               ),
  //               0
  //           ) AS promo_discount_percent,

  //           COALESCE(
  //               (
  //                   SELECT
  //                       prds.ebook_price -
  //                       (
  //                           promo.discount / 100 * prds.ebook_price
  //                       )
  //                   FROM promos AS promo
  //                   INNER JOIN promo_products AS promo_prods
  //                       ON promo_prods.promo_id = promo.id
  //                   WHERE promo_prods.product_id = prds.id
  //                     AND promo.applicable_product_type != 'physical'
  //                     AND promo.status = 'ACTIVE'
  //                     AND promo_prods.deleted_at IS NULL
  //                   LIMIT 1
  //               ),
  //               0
  //           ) AS promo_discount_price,

  //         COALESCE(prds.status,'') as status          
          
  //       ");    

  //     $query->where("prds.id","=",$BookID); 
  //     $query->where("prds.file_url","!=",null);    
      
      
  //   $info = $query->first();
                             
  //    return $info;             
           
  // }
  

  public function getBookInfoByID($BookID){

    $query = DB::table('products as prds')
        ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'prds.id')
        ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'prds.id')
        ->leftJoin('vw_product_active_promo as promo', 'promo.product_id', '=', 'prds.id')
        ->selectraw("
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

            CONCAT(
                COALESCE(prds.name, ''), ' ',
                COALESCE(prds.author, ''), '',
                COALESCE(prds.book_type, ''), '',
                COALESCE(prds.subtitle, '')
            ) AS search_fields,

            COALESCE(img.image_path, '') AS image_path,
            COALESCE(rt.rating, 0) AS rating,
            COALESCE(promo.promo_discount_percent, 0) AS promo_discount_percent,
            COALESCE(
                prds.ebook_price - (promo.promo_discount_percent / 100 * prds.ebook_price),
                0
            ) AS promo_discount_price,

            COALESCE(prds.status,'') as status
        ");

    $query->where("prds.id", "=", $BookID);
    $query->whereNotNull("prds.file_url");

    $info = $query->first();

    return $info;
}

 // BOOK CATEGORY
  public function getAllBookCatergoryList(){

    $CacheKey = 'all_book_category_list';

    $list = Cache::remember($CacheKey, now()->addDay(), function () {

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

          return $query->get();
    });

    return $list;

}

 //HEADER CATALOGUE 
  public function getHeaderCatalogueList(){

    $CacheKey = 'header_catalogue_list';

    $list = Cache::remember($CacheKey, now()->addHours(5), function () {

        $query = DB::table('product_catalog_headers as prod_hdrs_cat')
           ->selectraw("
              prod_hdrs_cat.id  as prod_hdrs_cat_ID,
              COALESCE(prod_hdrs_cat.name,'') as CatalogueName,
              COALESCE(prod_hdrs_cat.status,'') as status
            ");
           $query->where("prod_hdrs_cat.status","=",1);

          return $query->limit(10)->get(); // get temp 10
    });

    return $list;

}

 // CATALOGUE DETAILS
public function getDetailsCatalogueList($data){

    $HeaderID = $data['HeaderID'];

    $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

    $CacheKey = 'details_catalogue_list_' . $HeaderID . '_' . $UserID;

    $list = Cache::remember($CacheKey, now()->addMinutes(10), function () use ($HeaderID, $UserID) {

        $query = DB::table('product_catalog_details as prod_det_cat')
            ->join('product_catalog_headers as prod_hdrs_cat', 'prod_hdrs_cat.id', '=', 'prod_det_cat.product_catalog_header_id')
            ->join('products as prds', 'prds.id', '=', 'prod_det_cat.product_id')

            ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'prds.id')
            ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'prds.id')

            ->leftJoin('vw_product_active_promo as promo', 'promo.product_id', '=', 'prds.id')
            
            ->leftJoin('vw_customer_bookmarks as bm', function ($join) use ($UserID) {
                $join->on('bm.product_id', '=', 'prds.id')
                     ->where('bm.customer_id', '=', $UserID);
            })
            ->leftJoin('vw_customer_library as cl', function ($join) use ($UserID) {
                $join->on('cl.product_id', '=', 'prds.id')
                     ->where('cl.user_id', '=', $UserID);
            })
            ->selectraw("
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

                COALESCE(img.image_path, '') as image_path,
                COALESCE(rt.rating, 0) as rating,
                COALESCE(promo.promo_discount_percent, 0) as promo_discount_percent,
                COALESCE(
                    prds.ebook_price - (promo.promo_discount_percent / 100 * prds.ebook_price),
                    0
                ) as promo_discount_price,

                COALESCE(bm.chapter_no, '') as chapter_no,
                COALESCE(cl.product_id, 0) as product_library_exist,

                COALESCE(prds.status,'') as status
            ");

        $query->whereNull("prds.deleted_at");
        $query->whereRaw("prod_det_cat.product_catalog_header_id = ?", [$HeaderID]);

        return $query->limit(15)->get();  // get temp 10
    });

    return $list;
}

//  public function getDetailsCatalogueList($data){

//     $HeaderID = $data['HeaderID'];

//     $UserID = isset($data['UserID']) ? (int)$data['UserID'] : 0;

//     $CacheKey = 'details_catalogue_list_' . $HeaderID . '_' . $UserID;

//     $list = Cache::remember($CacheKey, now()->addMinutes(10), function () use ($HeaderID, $UserID) {

//         $query = DB::table('product_catalog_details as prod_det_cat')
//         ->join('product_catalog_headers as prod_hdrs_cat', 'prod_hdrs_cat.id', '=', 'prod_det_cat.product_catalog_header_id')
//         ->join('products as prds', 'prds.id', '=', 'prod_det_cat.product_id')

//          ->selectraw("    
//             prod_hdrs_cat.name  as header_name,

//             prds.id as book_ID,

//             COALESCE(prds.name,'') as name,
//             COALESCE(prds.author,'') as author,
//             COALESCE(prds.subtitle,'') as subtitle,
//             COALESCE(prds.description,'') as  short_description,
            
//             COALESCE(prds.slug,'') as slug,
//             COALESCE(prds.file_url,'') as file_url,          

//             COALESCE(prds.category_id,0) as category_id,
//             COALESCE(prds.book_type,'') as book_type,          
        
//             COALESCE(prds.sku,'') as sku,          
//             COALESCE(prds.size,'') as size,
//             COALESCE(prds.weight,'') as weight,
//             COALESCE(prds.texture,'') as texture,
//             COALESCE(prds.uom,'') as uom,

//             COALESCE(prds.is_featured,0) as is_featured,
//             COALESCE(prds.is_best_seller,0) as is_best_seller,
//             COALESCE(prds.is_free,0) as is_free,
//             COALESCE(prds.is_premium,0) as is_premium,

//             COALESCE(prds.ebook_price,0) as price,   
//             COALESCE(prds.ebook_discount_price,0) as discount_price,      
            
//             COALESCE(prds.reorder_point,0) as reorder_point,  
//             COALESCE(prds.read_count,0) as read_count,  

//             CONCAT(COALESCE(prds.name,''),' ', COALESCE(prds.author,''),'', COALESCE(prds.book_type,'') ,'', COALESCE(prds.subtitle,'')) as search_fields,

//             COALESCE((
//                  SELECT 
//                     prod_img.path FROM 
//                         product_photos as prod_img                  
//                        WHERE prod_img.product_id = prod_det_cat.product_id   
//                           AND prod_img.is_primary = 1 
//                       LIMIT 1                                
//                 )
//           ,'') as image_path,

//            COALESCE((
//                SELECT ROUND(avg(rating))
//                     FROM product_reviews as rev
//                     WHERE rev.product_id = prds.id
//                   AND rev.status = 1 
//                   LIMIT 1                                
//                 )
//           ,0) as rating,

//           COALESCE((
//                  SELECT 
//                     promo.discount FROM 
//                           promos as promo                  
//                     INNER JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
//                          WHERE promo_prods.product_id = prod_det_cat.product_id  
//                          AND promo.applicable_product_type !='physical'
//                          AND promo.status = 'ACTIVE'                     
//                          AND promo_prods.deleted_at IS NULL 
//                          LIMIT 1                                
//                 )
//           ,0) as promo_discount_percent,

//           COALESCE((
//                  SELECT 
//                      (prds.ebook_price - (promo.discount/100 * prds.ebook_price)) FROM 
//                           promos as promo                  
//                     INNER JOIN promo_products as promo_prods ON promo_prods.promo_id = promo.id  
//                          WHERE promo_prods.product_id = prod_det_cat.product_id  
//                          AND promo.applicable_product_type !='physical'
//                          AND promo.status = 'ACTIVE'                     
//                          AND promo_prods.deleted_at IS NULL LIMIT 1                                
//                 )
//           ,0) as promo_discount_price,

//            COALESCE((
//              SELECT 
//                  bkmrk.chapter_no FROM 
//                       book_marks as bkmrk                  
//                        WHERE bkmrk.product_id = prds.id    
//                        AND bkmrk.customer_id= ?
//                        LIMIT 1                                
//             )
//         ,'') as chapter_no,

//            COALESCE((
//                  SELECT 
//                     cust_lib.product_id FROM 
//                   customer_libraries as cust_lib                                    
//                         WHERE cust_lib.product_id = prds.id 
//                         AND cust_lib.user_id= ? LIMIT 1                                
//                 )
//           ,0) as product_library_exist,


//             COALESCE(prds.status,'') as status        

//      ", [$UserID, $UserID]);

//          $query->where("prds.deleted_at","=",null);
//          $query->whereRaw("prod_det_cat.product_catalog_header_id =?",[$HeaderID]);

//        return $query->limit(15)->get();  // get temp 10
//     });

//     return $list;

// }


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