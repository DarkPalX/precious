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
use App\Models\APIModels\Book;
use App\Models\APIModels\UserCustomer;

class Review extends Model
{
  
 public function getReviewList($data){
    
    $ProductID  = $data['ProductID'];
    $Status     = $data['Status'];
    $SearchText = $data['SearchText'];
    
    $Limit  = $data['Limit'];
    $PageNo = $data['PageNo'];

    // Create unique cache key based on request parameters
    $cacheKey = 'review_list_' . $ProductID . '_' . $Status . '_' . md5($SearchText);

    return Cache::remember($cacheKey, now()->addMinutes(10), function () use (
        $ProductID,
        $Status,
        $SearchText
    ) {

        $query = DB::table('product_reviews as revs')
            ->join('users as usrs', 'usrs.id', '=', 'revs.user_id')

            ->selectraw("
                revs.id as review_ID,

                COALESCE(usrs.avatar,'') as avatar,

                COALESCE(revs.product_id,0) as product_id,
                COALESCE(revs.product_name,'') as product_name,
                COALESCE(revs.user_id,0) as user_id,
                COALESCE(revs.name,'') as name,
                COALESCE(revs.email,'') as email,
                COALESCE(revs.comment,'') as comment,
                COALESCE(revs.rating,0) as rating,

                DATE_FORMAT(
                    revs.created_at,
                    '%m/%d/%Y %H:%i'
                ) as rating_date_format,

                COALESCE(revs.status,'') as status,
                COALESCE(revs.created_at,'') as created_at
            ");

        $query->where('revs.product_id', '=', $ProductID);
        $query->where('revs.status', '=', 1);

        if($SearchText != ''){

            $arSearchText = explode(" ", $SearchText);

            if(count($arSearchText) > 0){

                for($x = 0; $x < count($arSearchText); $x++) {

                    $search = str_replace("'", "''", $arSearchText[$x]);

                    $query->whereRaw(
                        "CONCAT_WS(' ',
                            COALESCE(revs.product_name,''),
                            COALESCE(revs.comment,'')
                        ) LIKE '%".$search."%'"
                    );
                }
            }
        }

        $query->orderBy('revs.created_at', 'DESC');

        return $query->limit(50)->get();
    });
}

  public function doPostComment($data) {

    $Misc  = New Misc();
    $Book  = New Book();
    $UserCustomer  = New UserCustomer();

    $TODAY = date("Y-m-d H:i:s");
    
    $ProductName="";

    $FullName="";
    $EmailAddress="";

    $UserID=$data['UserID'];
    $ProductID=$data['ProductID'];

    $Comment=$data['Comment'];
    $Rating=$data['Rating'];
    
    if($UserID> 0){

     $info=$Book->getBookInfoByID($ProductID);
     if(isset($info)>0){
         $ProductName=$info->name;
     }

      $info=$UserCustomer->getCustomerInformation($data);
     if(isset($info)>0){
         $FullName=$info->fullname;
         $EmailAddress=$info->emailaddress;
     }
          
      $ProductReviewID = DB::table('product_reviews')
            ->insertGetId([                                    
              'product_id' => $ProductID,
              'product_name' => $ProductName,                        
              'user_id' => $UserID,
              'name' => $FullName,                        
              'email' => $EmailAddress,                         
              'comment' => trim($Comment), 
              'rating' => $Rating, 
              'status' => 0, 
              'created_at' => $TODAY,             
              'updated_at' => $TODAY,             
            ]);

       }

    return 'Success';

  }

}