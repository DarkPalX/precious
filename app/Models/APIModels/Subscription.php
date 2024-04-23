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
use App\Models\APIModels\UserCustomer;

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
   
    $Misc  = New Misc();
    $UserCustomer  = New UserCustomer();

    $TODAY = date("Y-m-d H:i:s");
    $PaymentDate = date("Y-m-d");
    
    $StartDate = date("Y-m-d");
    $EndDate = date("Y-m-d");
    $EndDateFormatted="";

    $Platform=$data['Platform'];
    
    $UserID=$data['UserID'];    
    $SubscriptionPlanID=$data['SubscriptionPlanID'];

    $UsedECredit=$data['ApplyECredit'];  
    $CurrentEWalletCredit=0; 

    $PaymentMethod=$data['PaymentMethod'];
    $SubTotal=$data['SubTotal'];

    $GrossAmount=$SubTotal;
    $NetAmount=$SubTotal;

    if($PaymentMethod=='Debit Card/Credit Card' ||  $PaymentMethod=='EWallet'){
       $PaymentStatus='PAID';
    }else{
        $PaymentStatus='UNPAID';
    }
    
    if($UserID>0){

       $customer_info=$UserCustomer->getCustomerInformation($data);          
       if(isset($customer_info)>0){
          $CustomerName=$customer_info->fullname;
          $CustomerEmailAddress=$customer_info->emailaddress;
          $CustomerMobileNo=$customer_info->mobile;

          $CompleteAddress=$customer_info->address_street.' ,'.$customer_info->address_city;
          $CompleteDeliveryAddress=$customer_info->address_street.' ,'.$customer_info->address_city;
          $ZipCode=$customer_info->address_zip;  
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

    // save to customer subscription
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

    //save to sales header
    $OrderNo=$Misc->getNextOrderNumberFormat();      
    $SalesHeaderID = DB::table('ecommerce_sales_headers')
        ->insertGetId([                                            
          'user_id' => $UserID,              
          'order_number' => $OrderNo,                                            
          'order_source' => $Platform,                                            
          'customer_name' => $CustomerName, 
          'customer_email' => $CustomerEmailAddress, 
          'customer_contact_number' => $CustomerMobileNo, 
          'customer_address' => $CompleteAddress, 
          'customer_delivery_adress' => $CompleteDeliveryAddress, 
          'customer_delivery_zip' => $ZipCode,                           
          'gross_amount' => $GrossAmount, 
          'net_amount' => $NetAmount, 
          'discount_amount' => 0, 
          'gross_amount' => $GrossAmount, 
          'payment_method' => $PaymentMethod,
          'payment_status' => $PaymentStatus, 
          'ecredit_amount' => $UsedECredit, 
          'delivery_type' => 'd2d', 
          'delivery_status' => 'Delivered', 
          'delivery_fee_amount' => 0, 
          'delivery_fee_discount' => 0, 
          'status' => 'Active', 
          'created_at' => $TODAY             
        ]);


        if($SalesHeaderID>0 && $User_Subscription_ID>0){

      //PAYMENT
      $ReceiptNo=$Misc->GenerateRandomNo(6,'ecommerce_sales_headers','order_number'); 
      $PaymentHeaderID = DB::table('ecommerce_sales_payments')
         ->insertGetId([                                            
          'sales_header_id' => $SalesHeaderID,              
          'payment_type' => $PaymentMethod,                                            
          'amount' => $NetAmount,                                            
          'status' => $PaymentStatus, 
          'payment_date' => $PaymentDate, 
          'receipt_number' => $ReceiptNo,
          'created_by' => $UserID,
          'created_at' => $TODAY             
        ]); 


        // SAVE TO SALES DETAIL
        $SalesDetailID = DB::table('ecommerce_sales_details')
            ->insertGetId([                                            
              'sales_header_id' => $SalesHeaderID,              
              'product_id' => 0,        
              'subscription_plan_id' => $SubscriptionPlanID,              
              'product_name' => $TitlePlan, 
              'product_category' =>0,              
              'price' => $SubTotal,              
              'qty' => 1, 
              'uom' => '', 
              'tax_amount' =>0,              
              'promo_id' =>0,  
              'promo_description' =>'',  
              'tax_amount' =>0,  
              'discount_amount' => '0',                        
              'gross_amount' => $GrossAmount,                                                        
              'net_amount' => $NetAmount,
              'created_by' => $UserID,                        
              'created_at' => $TODAY             
          ]); 

       //EWALLET PAYMENT METHOD
       if($PaymentMethod=='EWallet'){
             if($UsedECredit>0){

                //Save to EWallet Credit History
                 $BalanceEWalletCredit=$CurrentEWalletCredit-$UsedECredit;
                   $CreditBalanceID = DB::table('ecredits')
                    ->insertGetId([                                            
                      'user_id' => $UserID,              
                      'used_credits' => $UsedECredit,                                              
                      'balance' => $BalanceEWalletCredit,  
                      'remarks' => 'Used '.$UsedECredit.' e-credit as payment for subscription with order no. '.$OrderNo,
                      'created_at' => $TODAY             
                  ]); 
            
               // Update Customer EWallet     
                 DB::table('users')
                  ->where('id',$UserID)
                  ->update([                              
                    'ecredits' => $BalanceEWalletCredit,                                                            
                    'updated_at' => $TODAY
                ]);  
               
               //Send Notification Message
               $MessageNotificationID = DB::table('message_notification')
                    ->insertGetId([                                            
                      'user_id' => $UserID,                                                         
                      'message_notification' => 'You have successfully subscribe to a '.$TitlePlan. " plan & it will expire on ".$EndDateFormatted. " .",
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
    $CurrentDayFormatted=date_format(date_create($CurrentDay),'M. j, Y ');

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
          $TitlePlan=$customer_info->title_plan;                   
          $PlanNoDays=$customer_info->no_days;                       
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
                      'message_notification' => 'Your '.$TitlePlan. " has ended today ".$CurrentDayFormatted. ".",
                      'created_at' => $TODAY             
                  ]);  
                
            }
         }
       } 
    }

    return 'Success';
  }
  
}