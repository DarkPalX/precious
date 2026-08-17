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

class EWallet extends Model
{
  
  // public function getEWalletHistoryList($data){
    
  //   $UserID=$data['UserID'];
    
  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];
    
  //   $query = DB::table('ecredits as ecr')
  //     ->join('users as usrs', 'usrs.id', '=', 'ecr.user_id')         
  //      ->selectraw("
  //         ecr.id as ecredit_ID,
          
  //         COALESCE(ecr.user_id,0) as user_id,
  //         COALESCE(ecr.used_credits,0) as used_credits,
  //         COALESCE(ecr.added_credits,0) as added_credits,
  //         COALESCE(ecr.balance,0) as running_balance,
  //         COALESCE(ecr.remarks,'') as remarks,        
  //         COALESCE(ecr.created_at,'') as created_at      
          
  //       ");    

  //     $query->where("ecr.user_id",'=',$UserID);                                


  //   // if($Limit > 0){
  //   //   $query->limit($Limit);
  //   //   $query->offset(($PageNo-1) * $Limit);
  //   // }

  //   $query->orderBy("ecr.created_at","DESC");    
  //   $list = $query->limit(50)->get();  // get temp 10
                             
  //    return $list;             
           
  // }
  

  public function getEWalletHistoryList($data){
    
    $UserID = $data['UserID'];
    
    $Status     = $data['Status'];
    $SearchText = $data['SearchText'];
    
      $Limit  = $data['Limit'];
      $PageNo = $data['PageNo'];

      // 10-minute cache
      $cacheKey = 'ewallet_history_' . $UserID;

      return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($UserID) {

          $query = DB::table('ecredits as ecr')
              ->join('users as usrs', 'usrs.id', '=', 'ecr.user_id')
              ->selectraw("
                  ecr.id as ecredit_ID,
                  
                  COALESCE(ecr.user_id,0) as user_id,
                  COALESCE(ecr.used_credits,0) as used_credits,
                  COALESCE(ecr.added_credits,0) as added_credits,
                  COALESCE(ecr.balance,0) as running_balance,
                  COALESCE(ecr.remarks,'') as remarks,
                  COALESCE(ecr.created_at,'') as created_at
              ");

          $query->where('ecr.user_id', '=', $UserID);

          $query->orderBy('ecr.created_at', 'DESC');

          return $query->limit(50)->get();
      });
  }

}