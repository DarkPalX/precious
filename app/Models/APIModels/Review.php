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

  /**
   * Build a case-insensitive regex for one bad word.
   * - matches whole words only (so "class" or "assistant" are NOT censored)
   * - allows leetspeak (sh1t, @sshole)
   * - allows repeated letters (fuuuck)
   * - allows common endings (fucker, fucking, shits)
   */
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

  /**
   * Replace bad words in a text with asterisks (same length as the word).
   * Example: "you are a fucking idiot" => "you are a ******* idiot"
   */
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

      // preg_replace_callback returns null on regex error, keep text safe
      if($text === null){
        return '';
      }
    }

    return $text;
  }

  /**
   * Returns true if the text contains at least one bad word.
   * Useful if you want to reject the comment instead of censoring it.
   */
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

        // ── NEW: one row per review with the number of VISIBLE replies ──
        // Aggregated in a sub-query first, then LEFT JOINed, so a review
        // with many replies is still returned as a single row (no row
        // multiplication) and a review with no replies gets 0.
        // Only approved replies (status = 1) are counted, which matches
        // what getReviewReplyList() actually returns to the app.
        $replyCounts = DB::table('product_reviews_reply')
            ->selectRaw('product_review_id, COUNT(*) as total_reply')
            ->where('product_id', '=', $ProductID)
            ->where('status', '=', 1)
            ->groupBy('product_review_id');

        $query = DB::table('product_reviews as revs')
            ->join('users as usrs', 'usrs.id', '=', 'revs.user_id')
            ->leftJoinSub($replyCounts, 'rc', 'rc.product_review_id', '=', 'revs.id')

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

        if($SearchText != ''){

            $arSearchText = explode(" ", $SearchText);

            if(count($arSearchText) > 0){

                for($x = 0; $x < count($arSearchText); $x++) {

                    $search = trim($arSearchText[$x]);

                    if($search === ''){
                        continue;
                    }

                    // bound parameter instead of string concatenation
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

    // Censor bad words
    $Reply = $this->filterBadWords($Reply);

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