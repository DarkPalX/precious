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

  //BAD WORDS FILTER ====================================================
  private $defaultBadWords = [
    // English
    'fuck', 'shit', 'bitch', 'asshole', 'bastard', 'dick', 'pussy',
    'cunt', 'slut', 'whore', 'motherfucker', 'nigger', 'faggot',
    // Filipino / Tagalog
    'putang ina', 'putangina', 'puta', 'tangina', 'tang ina', 'gago',
    'gaga', 'tarantado', 'ulol', 'bobo', 'tanga', 'pakyu', 'bwisit',
    'leche', 'pokpok', 'kantot', 'hindot', 'burat', 'tite', 'puki',
    'pekpek', 'kupal', 'inutil', 'lintik', 'hayop ka',
  ];

  //replce letter with these
  private $leetMap = [
    'a' => '[a@4]',
    'e' => '[e3]',
    'i' => '[i1!|]',
    'o' => '[o0]',
    's' => '[s$5]',
    't' => '[t7+]',
    'u' => '[uv]',
  ];

  private function getBadWords(){

    $words = config('badwords.words', $this->defaultBadWords);

    return is_array($words) ? $words : $this->defaultBadWords;
  }

  private function buildBadWordPattern($word){

    $word    = mb_strtolower(trim($word), 'UTF-8');
    $letters = preg_split('//u', $word, -1, PREG_SPLIT_NO_EMPTY);
    $pattern = '';

    foreach($letters as $ch){

      if($ch === ' '){
        $pattern .= '\s+';
        continue;
      }

      $class = isset($this->leetMap[$ch]) ? $this->leetMap[$ch] : preg_quote($ch, '/');

      // + allows repeated letters: fuuuck
      $pattern .= $class . '+';
    }

    return '/(?<![\p{L}\p{N}])' . $pattern . '(?:s|es|ed|er|ers|ing|in)?(?![\p{L}\p{N}])/iu';
  }

  public function filterBadWords($text, $mask = '*'){

    $text = (string) $text;

    if(trim($text) === ''){
      return $text;
    }

    foreach($this->getBadWords() as $word){

      if(trim($word) === ''){
        continue;
      }

      $text = preg_replace_callback(
        $this->buildBadWordPattern($word),
        function($m) use ($mask){
          return str_repeat($mask, mb_strlen($m[0], 'UTF-8'));
        },
        $text
      );

      if($text === null){
        return '';
      }
    }

    return $text;
  }


  public function hasBadWords($text){

    $text = (string) $text;
    foreach($this->getBadWords() as $word){
      if(trim($word) !== '' && preg_match($this->buildBadWordPattern($word), $text)){
        return true;
      }
    }

    return false;
  }

  //REVIEW LIST ==========================================================

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

        // Number of APPROVED replies per review.
     
        $replyCounts = DB::table('product_reviews')
            ->selectRaw('parent_id, COUNT(*) as total_reply')
            ->where('product_id', '=', $ProductID)
            ->where('parent_id', '>', 0)
            ->where('status', '=', 1)
            ->whereNull('deleted_at')
            ->groupBy('parent_id');

        $query = DB::table('product_reviews as revs')
            ->join('users as usrs', 'usrs.id', '=', 'revs.user_id')
            ->leftJoinSub($replyCounts, 'rc', 'rc.parent_id', '=', 'revs.id')

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
                COALESCE(revs.created_at,'') as created_at,

                COALESCE(rc.total_reply,0) as reply_count
            ");

        $query->where('revs.product_id', '=', $ProductID);
        $query->where('revs.status', '=', 1);
        $query->whereNull('revs.deleted_at');

        // ONLY real reviews - replies (parent_id > 0) must never show up here
        $query->where(function ($q) {
            $q->whereNull('revs.parent_id')
              ->orWhere('revs.parent_id', '=', 0);
        });

        if($SearchText != ''){

            $arSearchText = explode(" ", $SearchText);

            if(count($arSearchText) > 0){

                for($x = 0; $x < count($arSearchText); $x++) {

                    $search = trim($arSearchText[$x]);

                    if($search === ''){
                        continue;
                    }

                    $query->whereRaw(
                        "CONCAT_WS(' ',
                            COALESCE(revs.product_name,''),
                            COALESCE(revs.comment,'')
                        ) LIKE ?",
                        ['%' . $search . '%']
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

    // Censor bad words
    $Comment = $this->filterBadWords($Comment);

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
              'parent_id' => null,      // a review, not a reply
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

    $query = DB::table('product_reviews as rr')
        ->join('users as usrs', 'usrs.id', '=', 'rr.user_id')

        ->selectRaw("
            rr.id as reply_ID,
            rr.parent_id as review_ID,
            COALESCE(usrs.avatar,'') as avatar,

            COALESCE(rr.product_id,0) as product_id,
            COALESCE(rr.user_id,0) as user_id,
            COALESCE(rr.name,'') as name,
            COALESCE(rr.email,'') as email,
            COALESCE(rr.comment,'') as reply,

            DATE_FORMAT(
                rr.created_at,
                '%m/%d/%Y %H:%i'
            ) as reply_date_format,

            COALESCE(rr.status,'') as status,
            COALESCE(rr.created_at,'') as created_at,

            CASE WHEN rr.user_id = ? THEN 1 ELSE 0 END as is_mine
        ", [$UserID]);

    $query->where('rr.parent_id', '=', $ProductReviewID);
    $query->where('rr.status', '=', 1);
    $query->whereNull('rr.deleted_at');


    $query->orderBy('rr.created_at', 'ASC');

    return $query->get();
  }

  public function doPostCommentReply($data) {

    $UserCustomer  = New UserCustomer();

    $TODAY = date("Y-m-d H:i:s");

    $FullName="";
    $EmailAddress="";

    $UserID          = (int) ($data['UserID'] ?? 0);
    $ProductReviewID = (int) ($data['ProductReviewID'] ?? 0);

    $Reply = trim((string) ($data['Reply'] ?? ''));

    if($UserID <= 0 || $ProductReviewID <= 0 || $Reply === ''){
      return 'Failed';
    }

    $parent = DB::table('product_reviews')
          ->where('id', '=', $ProductReviewID)
          ->where('status', '=', 1)
          ->whereNull('deleted_at')
          ->where(function ($q) {
              $q->whereNull('parent_id')->orWhere('parent_id', '=', 0);
          })
          ->first();

    if(!$parent){
      return 'Failed';
    }

    // Censor bad words
    $Reply = trim($this->filterBadWords($Reply));

    if($Reply === ''){
      return 'Failed';
    }

    $info=$UserCustomer->getCustomerInformation($data);
    if(isset($info)>0){
        $FullName=$info->fullname;
        $EmailAddress=$info->emailaddress;
    }

    DB::table('product_reviews')
          ->insertGetId([
            'parent_id'    => $ProductReviewID,       // the review this reply belongs to
            'product_id'   => $parent->product_id,
            'product_name' => $parent->product_name,
            'user_id'      => $UserID,                // the person who replied
            'name'         => $FullName,
            'email'        => $EmailAddress,
            'comment'      => $Reply,                 // reply text
            'rating'       => 0,                      // NOT NULL column; replies have no stars
            'status'       => 1,                      // No more admn approval
            'created_at'   => $TODAY,
            'updated_at'   => $TODAY,
          ]);

    return 'Success';

  }

}