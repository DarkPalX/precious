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
use App\Models\UserCustomer;

class Subscription extends Model
{
  
  public function getSubscriptionPlanList($data){

     $query = DB::table('subscriptions as subs')     
    
       ->selectraw("
          subs.id as Users_Subscriptions_ID,          

          COALESCE(subs.title,'') as title,

          COALESCE(subs.no_days,0) as no_days,
          COALESCE(subs.price,0) as price,

          COALESCE(subs.short_description,'') as short_description,
          COALESCE(subs.long_description,'') as long_description,

          COALESCE(subs.status,'') as status,
                    
          COALESCE(subs.created_at,0) as created_at
                        
        ");    
       
       $query->where("subs.status","=",'Active');  
   

     
    $query->orderBy("subs.id","ASC");     
    $list = $query->get();
                             
     return $list;    
    
  }

   public function getSubscriptionPlanInfo($PlanID){

     $query = DB::table('subscriptions as subs')  
       ->selectraw("
          subs.id as Users_Subscriptions_ID,          

          COALESCE(subs.title,'') as title,

          COALESCE(subs.no_days,0) as no_days,
          COALESCE(subs.price,0) as price,

          COALESCE(subs.short_description,'') as short_description,
          COALESCE(subs.long_description,'') as long_description,

          COALESCE(subs.status,'') as status,
                    
          COALESCE(subs.created_at,0) as created_at
                             
          
        ");    
      
      $query->whereRaw('subs.id =?',[$PlanID]);     
      
      $info = $query->first();

     return $info;      

  }

  function proceedToSubscribe($data){

    $UserCustomer  = New UserCustomer();

    $TODAY = date("Y-m-d H:i:s");
    $StartDate = date("Y-m-d");
    $EndDate = date("Y-m-d");
    
    $EndDateFormatted="";
    
    $UserID=$data['UserID'];    
    $SubscriptionPlanID=$data['SubscriptionPlanID'];
    $UsedECredit=$data['ApplyECredit'];

    $PaymentMethod=$data['PaymentMethod'];
    $SubTotal=$data['SubTotal'];

    if($UserID>0){

       $customer_info=$UserCustomer->getCustomerInformation($data);
       if(isset($customer_info)>0){  
          $CurrentEWalletCredit=$customer_info->ecredits;                      
       } 

     $TitlePlan="";
     $PlanNoDays=0;

     $plan_info=$this->getSubscriptionPlanInfo($SubscriptionPlanID);

       if(isset($plan_info)>0){
          $TitlePlan=$plan_info->title;                   
          $PlanNoDays=$plan_info->no_days;  
          $EndDate = date('Y-m-d', strtotime("+".$PlanNoDays." day"));          
          $EndDateFormatted=date_format(date_create($EndDate),'M. j, Y ');
       } 

    $User_Subscription_ID = DB::table('users_subscriptions')
        ->insertGetId([                                            
          'user_id' => $UserID,                                                                          
          'plan_id' => $SubscriptionPlanID, 
          'no_days' => $PlanNoDays, 
          'mode_payment' => $PaymentMethod, 
          'amount_paid' => $SubTotal,           
          'start_date' => $StartDate, 
          'end_date' => $EndDate, 
          'is_subscribe' => 1, 
          'created_at' => $TODAY             
        ]); 
        
   if($User_Subscription_ID>0){
      //EWALLET PAYMENT METHOD
       if($PaymentMethod=='EWallet'){
             if($UsedECredit>0){

                //UPDATE CURRENT BALANCE EWALLET
                 $BalanceEWalletCredit=$CurrentEWalletCredit-$UsedECredit;
                $CreditBalanceID = DB::table('ecredits')
                    ->insertGetId([                                            
                      'user_id' => $UserID,              
                      'used_credits' => $UsedECredit,                                              
                      'balance' => $BalanceEWalletCredit,  
                      'remarks' => 'Used '.$UsedECredit.' e-credit as payment for subscription to a '.$TitlePlan. " plan subscription.",
                      'created_at' => $TODAY             
                  ]); 
                 
                 DB::table('users')
                  ->where('id',$UserID)
                  ->update([                              
                    'ecredits' => $BalanceEWalletCredit,                                                            
                    'updated_at' => $TODAY
                ]); 

                $MessageNotificationID = DB::table('message_notification')
                    ->insertGetId([                                            
                      'user_id' => $UserID,                                                         
                      'message_notification' => 'You have successfully subscribe to a '.$TitlePlan. " plan & your subscription will expire on ".$EndDateFormatted. " .",
                      'created_at' => $TODAY             
                  ]);    
               }
           }   
       }
           
    }
    return 'Success';
  }

  function checkSubscriptionStatus($data){
 
    $UserCustomer= new UserCustomer();
    $TODAY = date("Y-m-d H:i:s");
    $CurrentDay = date("Y-m-d");

    $IsSubcscribe=0;
    $EndDate="";
    $ExpiryDateOneDayBefore="";

     $TitlePlan="";
     $PlanNoDays=0;

    $UserID=$data['UserID'];
    
     if($UserID>0){
       $customer_info=$UserCustomer->getCustomerInformation($data);

       if(isset($customer_info)>0){  
          $IsSubcscribe=$customer_info->is_subscribe;                      
          $EndDate=$customer_info->end_date; 
          $ExpiryDateOneDayBefore=date($EndDate, strtotime('-1 day')); 
          
         if($IsSubcscribe=1){
             
            //check current date if same as 1 day before the expiration date
            if($ExpiryDateOneDayBefore==$CurrentDay){
              //send message expiration date 1 day before the expiration date  
            }            
            //check current date hits the expiration date.
            if($EndDate<=$CurrentDay){
                
                DB::table('users_subscriptions')
                  ->where('user_id',$UserID)
                  ->update([            
                    'is_subscribe' => 0,                                                 
                    'is_expired' => 1,                                                          
                    'updated_at' => $TODAY
                ]); 

                 $MessageNotificationID = DB::table('message_notification')
                    ->insertGetId([                                            
                      'user_id' => $UserID,                                                         
                      'message_notification' => 'You have successfully subscribe to a '.$TitlePlan. " plan & your subscription will expire on ".$EndDateFormatted. " .",
                      'created_at' => $TODAY             
                  ]);  
                
            }
         }
       } 
    }

    return 'Success';
  }
  
}