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
   
  

  //REPLY ===============================================================
  public function getReviewReplyList($data){

    $ProductReviewID = (int) ($data['ProductReviewID'] ?? 0);
    $UserID          = (int) ($data['UserID'] ?? 0);

    $Limit  = (int) ($data['Limit'] ?? 100);
    $PageNo = (int) ($data['PageNo'] ?? 1);

    if ($Limit <= 0 || $Limit > 200) { $Limit = 100; }
    if ($PageNo <= 0) { $PageNo = 1; }

    if ($ProductReviewID <= 0) {
        return collect([]);
    }

    $query = DB::table('product_reviews_reply as rr')
        ->join('users as usrs', 'usrs.id', '=', 'rr.user_id')
         

           ->selectraw("
                rr.id as reply_ID,
                rr.product_review_id as review_ID,
                COALESCE(usrs.avatar,'') as avatar,

                COALESCE(rr.product_id,0) as product_id,
                COALESCE(rr.user_id,0) as user_id,
                COALESCE(rr.name,'') as name,
                COALESCE(rr.email,'') as email,
                COALESCE(rr.reply,'') as reply,
      
                DATE_FORMAT(
                    rr.created_at,
                    '%m/%d/%Y %H:%i'
                ) as reply_date_format,

                COALESCE(rr.status,'') as status,
                COALESCE(rr.created_at,'') as created_at
            ");
        
        $query->where('rr.product_review_id', '=', $ProductReviewID);
        $query->where('rr.status', '=', 1);

    return $query->get();
}

   public function doPostCommentReply($data) {

    $Misc  = New Misc();
    $Book  = New Book();
    $UserCustomer  = New UserCustomer();

    $TODAY = date("Y-m-d H:i:s");
    
    $FullName="";
    $EmailAddress="";

    $UserID=$data['UserID'];
    $ProductID=$data['ProductID'];
    $ProductReviewID=$data['ProductReviewID'];

    $Reply=$data['Reply'];
    
    if($UserID> 0){

     $info=$UserCustomer->getCustomerInformation($data);
     if(isset($info)>0){
         $FullName=$info->fullname;
         $EmailAddress=$info->emailaddress;
     }
          
      $ProductReviewID = DB::table('product_reviews_reply')
            ->insertGetId([    
              'product_review_id' => $ProductReviewID,                                   
              'product_id' => $ProductID,                  
              'user_id' => $UserID,
              'name' => $FullName,                        
              'email' => $EmailAddress,                         
              'reply' => trim($Reply), 
              'status' => 0, 
              'created_at' => $TODAY,             
              'updated_at' => $TODAY,             
            ]);

       }

    return 'Success';

  }

}