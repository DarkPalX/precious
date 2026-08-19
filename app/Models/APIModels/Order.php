<?php

namespace App\Models\APIModels;

use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

use Session;
use Hash;
use View;
use Input;
use Image;

use App\Models\APIModels\Misc;
use App\Models\APIModels\Email;
use App\Models\APIModels\Cart;
use App\Models\APIModels\Voucher;
use App\Models\APIModels\UserCustomer;

class Order extends Model
{
  
  // public function getOrderList($data){
    
  //   $UserID=$data['UserID'];

  //   $Status=$data['Status'];
  //   $SearchText=$data['SearchText'];
    
  //   $Limit=$data['Limit'];
  //   $PageNo=$data['PageNo'];

  //    $query = DB::table('ecommerce_sales_headers as sales_hdr')
  //    ->join('ecommerce_sales_payments as sales_pay', 'sales_pay.sales_header_id', '=', 'sales_hdr.id') 
     
  //      ->selectraw("
  //         sales_hdr.id as sales_Header_ID,

  //         COALESCE(sales_hdr.created_at,'') as order_date,
  //         DATE_FORMAT(sales_hdr.created_at,'%m/%d/%Y') as order_date_format,
          
  //         COALESCE(sales_hdr.order_number,'') as order_number,
  //         COALESCE(sales_hdr.order_source,'') as order_source,
  //         COALESCE(sales_hdr.customer_name,'') as customer_name,
          
  //         COALESCE(sales_hdr.customer_email,'') as customer_email,
  //         COALESCE(sales_hdr.customer_contact_number,'') as customer_contact_number,

  //         COALESCE(sales_hdr.customer_address,'') as customer_address,   

  //         COALESCE(sales_hdr.customer_delivery_adress,'') as customer_delivery_adress,                
  //         COALESCE(sales_hdr.customer_delivery_zip,'') as customer_delivery_zip,                
          
  //         COALESCE(sales_hdr.delivery_type,'') as delivery_type,          
  //         COALESCE(sales_hdr.delivery_fee_amount,0) as delivery_fee_amount,

  //         COALESCE(sales_hdr.gross_amount,0) as gross_amount,  
  //         COALESCE(sales_hdr.tax_amount,0) as tax_amount,
  //         COALESCE(sales_hdr.net_amount,0) as net_amount,
  //         COALESCE(sales_hdr.discount_amount,0) as discount_amount,

  //         COALESCE(sales_hdr.other_instruction,'') as order_instruction,
          
  //         COALESCE(sales_hdr.payment_status,'') as payment_status,        
  //         COALESCE(sales_hdr.other_instruction,'') as other_instruction,  

  //         COALESCE(sales_pay.payment_type,'') as payment_method,        
  //         COALESCE(sales_pay.amount,0) as payment_amount,        
  //         COALESCE(sales_pay.status,'') as payment_status,        
  //         COALESCE(sales_pay.receipt_number,'') as receipt_number,

  //         COALESCE(sales_hdr.status,'') as status          
          
  //       ");  

  //      $query->whereIn("sales_hdr.order_source",['Android','iOS']);    
  //      $query->where("sales_hdr.user_id",'=',$UserID);    

                                      
  //     if($SearchText != ''){
  //       $arSearchText = explode(" ",$SearchText);
  //       if(count($arSearchText) > 0){
  //           for($x=0; $x< count($arSearchText); $x++) {
  //               $query->whereraw(
  //                   "CONCAT_WS(' ',
  //                       COALESCE(sales_hdr.order_number,''),
  //                       COALESCE(sales_hdr.order_source,''),                        
  //                       COALESCE(sales_hdr.status,'')
  //                   ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
  //            }
  //       }
  //   }

  //   // if($Limit > 0){
  //   //   $query->limit($Limit);
  //   //   $query->offset(($PageNo-1) * $Limit);
  //   // }

  //   $query->orderBy("sales_hdr.created_at","DESC");    
  //    $list = $query->limit(20)->get(); // get temp 20
                             
  //    return $list;             
           
  // }

    public function getOrderList($data){
    
    $UserID=$data['UserID'];
    $Status=$data['Status'];
    $SearchText=$data['SearchText'];
    
    $Limit=$data['Limit'];
    $PageNo=$data['PageNo'];

    $CacheKey = "order_list_{$UserID}_{$Status}_{$SearchText}_{$Limit}_{$PageNo}";

    $list = Cache::remember($CacheKey, now()->addMinutes(3), function () use ($UserID, $Status, $SearchText, $Limit, $PageNo) {

        $query = DB::table('ecommerce_sales_headers as sales_hdr')
         ->join('ecommerce_sales_payments as sales_pay', 'sales_pay.sales_header_id', '=', 'sales_hdr.id') 
         
           ->selectraw("
              sales_hdr.id as sales_Header_ID,
              COALESCE(sales_hdr.created_at,'') as order_date,
              DATE_FORMAT(sales_hdr.created_at,'%m/%d/%Y') as order_date_format,
              
              COALESCE(sales_hdr.order_number,'') as order_number,
              COALESCE(sales_hdr.order_source,'') as order_source,
              COALESCE(sales_hdr.customer_name,'') as customer_name,
              
              COALESCE(sales_hdr.customer_email,'') as customer_email,
              COALESCE(sales_hdr.customer_contact_number,'') as customer_contact_number,
              COALESCE(sales_hdr.customer_address,'') as customer_address,   
              COALESCE(sales_hdr.customer_delivery_adress,'') as customer_delivery_adress,                
              COALESCE(sales_hdr.customer_delivery_zip,'') as customer_delivery_zip,                
              
              COALESCE(sales_hdr.delivery_type,'') as delivery_type,          
              COALESCE(sales_hdr.delivery_fee_amount,0) as delivery_fee_amount,
              COALESCE(sales_hdr.gross_amount,0) as gross_amount,  
              COALESCE(sales_hdr.tax_amount,0) as tax_amount,
              COALESCE(sales_hdr.net_amount,0) as net_amount,
              COALESCE(sales_hdr.discount_amount,0) as discount_amount,
              COALESCE(sales_hdr.other_instruction,'') as order_instruction,
              
              COALESCE(sales_hdr.payment_status,'') as payment_status,        
              COALESCE(sales_hdr.other_instruction,'') as other_instruction,  
              COALESCE(sales_pay.payment_type,'') as payment_method,        
              COALESCE(sales_pay.amount,0) as payment_amount,        
              COALESCE(sales_pay.status,'') as payment_status,        
              COALESCE(sales_pay.receipt_number,'') as receipt_number,
              COALESCE(sales_hdr.status,'') as status          
              
            ");  
           $query->whereIn("sales_hdr.order_source",['Android','iOS']);    
           $query->where("sales_hdr.user_id",'=',$UserID);    
                                          
          if($SearchText != ''){
            $arSearchText = explode(" ",$SearchText);
            if(count($arSearchText) > 0){
                for($x=0; $x< count($arSearchText); $x++) {
                    $query->whereraw(
                        "CONCAT_WS(' ',
                            COALESCE(sales_hdr.order_number,''),
                            COALESCE(sales_hdr.order_source,''),                        
                            COALESCE(sales_hdr.status,'')
                        ) like '%".str_replace("'", "''", $arSearchText[$x])."%'");
                 }
            }
        }
        // if($Limit > 0){
        //   $query->limit($Limit);
        //   $query->offset(($PageNo-1) * $Limit);
        // }
        $query->orderBy("sales_hdr.created_at","DESC");    
        return $query->limit(20)->get(); // get temp 20

    });
                             
     return $list;             
           
  }

  public function proceedToCheckOut($data){
    
    $Misc  = New Misc();
    $Cart = new Cart();
    $UserCustomer  = New UserCustomer();
    $Voucher  = New Voucher();

    $TODAY = date("Y-m-d H:i:s");
    $PaymentDate = date("Y-m-d");
    
    // CUSTOMER
    $CustomerName='';
    $CustomerEmailAddress='';
    $CustomerMobileNo='';

    $ZipCode='';
    $CompleteAddress='';
    $CompleteDeliveryAddress='';
    
    $GrossAmount='0';
    $TaxAmount='0';
    $NetAmount='0';    
    
    $Platform=$data['Platform'];
    $UserID=$data['UserID'];
    
    // $SubTotal=$data['SubTotal'];
    $AmountPaid=$data['AmountPaid'];
    $PaymentMethod=$data['PaymentMethod'];

    $UsedECredit=$data['ApplyECredit'];  
    $CurrentEWalletCredit=0;  

    $VoucherCode=$data['VoucherCode'];    
    $VoucherDiscountAmount=$data['VoucherDiscountAmount'];    

    if($PaymentMethod=='Debit Card/Credit Card' ||  $PaymentMethod=='EWallet' || $PaymentMethod=='PayPal'){
       $PaymentStatus='PAID';
    }else{
        $PaymentStatus='UNPAID';
    }

    $PayPalParamResponse=$data['PayPalParamResponse'];  

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

      $ProductPrice=0;
      $cart_info = $Cart->getCartInfoByUserID($UserID);
      if(count($cart_info)>0){
        foreach($cart_info as $list){
            if($list->discount_amount>0){
                $ProductPrice=$list->discount_amount;
            }else{
                $ProductPrice=$list->price;    
            }
           $GrossAmount= $GrossAmount + $ProductPrice;
        } 

        $NetAmount=$GrossAmount - $VoucherDiscountAmount;
      }
     

     
    //SAVE SALES HEADER
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
          'discount_amount' => $VoucherDiscountAmount, 
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
        
   if($SalesHeaderID>0){

      //SAVE TO SALES PAYMENT
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

      //SAVE COUPON TO COUPON SALES
       if($VoucherCode!=''){

         $CouponID=0;
         $info=$Voucher->getVoucherInfoByCode($VoucherCode);

         if(isset($info)>0){

            $CouponID=$info->coupon_ID;         
             $CopuponSalesID = DB::table('coupon_sales')
                  ->insertGetId([                                            
                  'customer_id' => $UserID,              
                  'coupon_id' => $CouponID,
                  'coupon_code' => $VoucherCode,
                  'sales_header_id' => $SalesHeaderID,
                  'order_status' => $PaymentStatus,                                                                
                  'created_at' => $TODAY             
                ]); 
         }
     }         
   

     // SAVE TO SALES DETAIL
     $cart_info = $Cart->getCartInfoByUserID($UserID);
     if(count($cart_info)>0){
        foreach($cart_info as $item_list){
        
        // SAVE TO SALES DETAIL
        $SalesDetailID = DB::table('ecommerce_sales_details')
            ->insertGetId([                                            
              'sales_header_id' => $SalesHeaderID,              
              'product_id' => $item_list->book_ID,              
              'product_name' => $item_list->name, 
              'product_category' => $item_list->category_id,              
              'price' => $item_list->price,              
              'qty' => 0, 
              'uom' => $item_list->uom, 
              'tax_amount' =>0,              
              'promo_id' =>0,  
              'promo_description' =>'',  
              'tax_amount' =>0,  
              'discount_amount' => $item_list->discount_amount,                        
              'gross_amount' => $GrossAmount,                                                        
              'net_amount' => $NetAmount,
              'created_by' => $UserID,                        
              'created_at' => $TODAY             
          ]); 

          // SAVE TO CUSATOMER LIBRARY BOOKS
           $SalesDetailID = DB::table('customer_libraries')
            ->insertGetId([                                            
              'user_id' => $UserID,              
              'product_id' => $item_list->book_ID,                                              
              'created_at' => $TODAY             
          ]); 
      
      }
        
      //DELET CART ITEMS
       DB::table('ecommerce_shopping_cart')
          ->where('user_id', $UserID)->delete();  


       // EWALLET PAYMENT METHOD
       if($PaymentMethod=='EWallet'){
             if($UsedECredit>0){

                //UPDATE CURRENT BALANCE EWALLET
                 $BalanceEWalletCredit=$CurrentEWalletCredit-$UsedECredit;

                   $CreditBalanceID = DB::table('ecredits')
                    ->insertGetId([                                            
                      'user_id' => $UserID,              
                      'used_credits' => $UsedECredit,                                              
                      'balance' => $BalanceEWalletCredit,  
                      'remarks' => 'Used '.$UsedECredit.' e-credit as payment for order no. '.$OrderNo,
                      'created_at' => $TODAY             
                  ]); 

                 
                 DB::table('users')
                  ->where('id',$UserID)
                  ->update([                              
                    'ecredits' => $BalanceEWalletCredit,                                                            
                    'updated_at' => $TODAY
                ]);    

             }
 
        // PAYPAL PAYMENT METHOD
       }else if($PaymentMethod=='PayPal'){

             $PayPalTransID = DB::table('paypal_payment')
                ->insertGetId([                                            
                  'user_id' => $UserID,                                                   
                  'paypal_param_response' =>$PayPalParamResponse,
                  'sales_header_id' => $SalesHeaderID,    
                   'Status' => 'Success',                   
                  'payment_date_time' => $TODAY             
              ]); 

         }        
      } 
  }
        
   
    //SEND EMAIL NOTIF
     if($SalesHeaderID>0){

        $OrderInfo= $this->getOrderInfo($SalesHeaderID);        
          if($OrderInfo->SalesHeaderID>0){
              $param['OrderID']=$OrderInfo->SalesHeaderID;
              $param['EmailAddress']=$OrderInfo->customer_email;
              $param["MobileNo"] = $OrderInfo->customer_contact_number;
              $param['OrderNo']=$OrderInfo->order_number;        
              $param['OrderInfo']=$OrderInfo;
              $param['OrderItem']=$this->getOrderItemList($SalesHeaderID);
              
              $Email = new Email();
              $Email->SendOrderReceivedEmail($param);    
          }

       }
    
    }
    return 'Success';
  }


// public function proceedToCheckOut($data)
// {
//     $Misc         = new Misc();
//     $Cart         = new Cart();
//     $UserCustomer = new UserCustomer();
//     $Voucher      = new Voucher();

//     $TODAY       = date("Y-m-d H:i:s");
//     $PaymentDate = date("Y-m-d");

//     // CUSTOMER
//     $CustomerName            = '';
//     $CustomerEmailAddress    = '';
//     $CustomerMobileNo        = '';
//     $ZipCode                 = '';
//     $CompleteAddress         = '';
//     $CompleteDeliveryAddress = '';

//     $GrossAmount = 0;
//     $TaxAmount   = 0;
//     $NetAmount   = 0;

//     $Platform              = $data['Platform'] ?? '';
//     $UserID                = $data['UserID'] ?? 0;
//     $AmountPaid            = $data['AmountPaid'] ?? 0;
//     $PaymentMethod         = $data['PaymentMethod'] ?? '';
//     $UsedECredit           = $data['ApplyECredit'] ?? 0;
//     $VoucherCode           = $data['VoucherCode'] ?? '';
//     $VoucherDiscountAmount = $data['VoucherDiscountAmount'] ?? 0;
//     $PayPalParamResponse   = $data['PayPalParamResponse'] ?? '';

   
//     if (!is_numeric($UserID) || (int) $UserID <= 0) {
//         return 'Invalid user.';
//     }

//     $UserID = (int) $UserID;

   
//     if (!is_numeric($UsedECredit)) {

//         \Log::error('Invalid e-credit request', [
//             'user_id' => $UserID,
//             'used_ecredit' => $UsedECredit,
//         ]);

//         return 'Invalid e-credit amount.';
//     }

//     $UsedECredit = (float) $UsedECredit;

//     if (!is_finite($UsedECredit)) {

//         \Log::error('Non-finite e-credit request', [
//             'user_id' => $UserID,
//             'used_ecredit' => $UsedECredit,
//         ]);

//         return 'Invalid e-credit amount.';
//     }

//     if ($UsedECredit < 0) {
//         return 'Invalid e-credit amount.';
//     }

   
//     $MaxECredit = 99999999999999.99;

//     if ($UsedECredit > $MaxECredit) {

//         \Log::error('E-credit request exceeds maximum', [
//             'user_id' => $UserID,
//             'used_ecredit' => $UsedECredit,
//         ]);

//         return 'Invalid e-credit amount.';
//     }

   
//     if (
//         $PaymentMethod == 'Debit Card/Credit Card' ||
//         $PaymentMethod == 'EWallet' ||
//         $PaymentMethod == 'PayPal'
//     ) {
//         $PaymentStatus = 'PAID';
//     } else {
//         $PaymentStatus = 'UNPAID';
//     }

  
//     $customer_info = $UserCustomer->getCustomerInformation($data);

//     if (!$customer_info) {
//         return 'Customer information not found.';
//     }

//     $CustomerName         = $customer_info->fullname;
//     $CustomerEmailAddress = $customer_info->emailaddress;
//     $CustomerMobileNo     = $customer_info->mobile;

//     $CompleteAddress =
//         $customer_info->address_street . ' ,' .
//         $customer_info->address_city;

//     $CompleteDeliveryAddress =
//         $customer_info->address_street . ' ,' .
//         $customer_info->address_city;

//     $ZipCode = $customer_info->address_zip;

//     $cart_info = $Cart->getCartInfoByUserID($UserID);

//     if (!$cart_info || count($cart_info) == 0) {
//         return 'Your cart is empty.';
//     }

  
//     foreach ($cart_info as $list) {

//         if (
//             !is_numeric($list->price) ||
//             !is_numeric($list->discount_amount)
//         ) {
//             return 'Invalid product price.';
//         }

//         if ((float) $list->discount_amount > 0) {
//             $ProductPrice = (float) $list->discount_amount;
//         } else {
//             $ProductPrice = (float) $list->price;
//         }

//         $GrossAmount += $ProductPrice;
//     }

    
//     if (!is_numeric($VoucherDiscountAmount)) {
//         return 'Invalid voucher discount.';
//     }

//     $VoucherDiscountAmount = (float) $VoucherDiscountAmount;

//     if ($VoucherDiscountAmount < 0) {
//         return 'Invalid voucher discount.';
//     }

//     $NetAmount = $GrossAmount - $VoucherDiscountAmount;

//     if ($NetAmount < 0) {
//         $NetAmount = 0;
//     }

  
//     if ($PaymentMethod == 'EWallet') {

//         if ($UsedECredit <= 0) {
//             return 'Please enter a valid e-credit amount.';
//         }

//         if ($UsedECredit > $NetAmount) {

//             \Log::warning('E-credit exceeds order total', [
//                 'user_id' => $UserID,
//                 'used_ecredit' => $UsedECredit,
//                 'net_amount' => $NetAmount,
//             ]);

//             return 'E-credit amount cannot be greater than the order total.';
//         }
//     }

   
//     try {

//         DB::beginTransaction();

    
//         $user = DB::table('users')
//             ->where('id', $UserID)
//             ->lockForUpdate()
//             ->first();

//         if (!$user) {
//             throw new \Exception('User not found.');
//         }

     
//         $CurrentEWalletCredit = $user->ecredits;

       
//         if (!is_numeric($CurrentEWalletCredit)) {

//             \Log::error('Invalid e-credit balance - non numeric', [
//                 'user_id' => $UserID,
//                 'balance' => $CurrentEWalletCredit,
//             ]);

//             throw new \Exception(
//                 'Your e-credit balance is invalid. Please contact support.'
//             );
//         }

//         $CurrentEWalletCredit = (float) $CurrentEWalletCredit;

      
//         if (!is_finite($CurrentEWalletCredit)) {

//             \Log::error('Invalid e-credit balance - non finite', [
//                 'user_id' => $UserID,
//                 'balance' => $CurrentEWalletCredit,
//             ]);

//             throw new \Exception(
//                 'Your e-credit balance is invalid. Please contact support.'
//             );
//         }

      

//         if ($CurrentEWalletCredit < 0) {

//             \Log::error('Negative e-credit balance detected', [
//                 'user_id' => $UserID,
//                 'balance' => $CurrentEWalletCredit,
//             ]);

//             throw new \Exception(
//                 'Your e-credit balance is invalid. Please contact support.'
//             );
//         }

    

//         if ($CurrentEWalletCredit > $MaxECredit) {

//             \Log::error('Corrupted e-credit balance detected', [
//                 'user_id' => $UserID,
//                 'balance' => $CurrentEWalletCredit,
//                 'maximum_allowed' => $MaxECredit,
//             ]);

//             throw new \Exception(
//                 'Your e-credit balance is invalid. Please contact support.'
//             );
//         }

       
//         if ($PaymentMethod == 'EWallet') {

           

//             if ($UsedECredit > $CurrentEWalletCredit) {

//                 \Log::warning('Insufficient e-credit balance', [
//                     'user_id' => $UserID,
//                     'balance' => $CurrentEWalletCredit,
//                     'requested' => $UsedECredit,
//                 ]);

//                 throw new \Exception(
//                     'Insufficient e-credit balance.'
//                 );
//             }

         
//             $BalanceEWalletCredit =
//                 $CurrentEWalletCredit - $UsedECredit;

          
//             if ($BalanceEWalletCredit < 0) {

//                 \Log::error('Negative e-credit result detected', [
//                     'user_id' => $UserID,
//                     'current_balance' => $CurrentEWalletCredit,
//                     'used_ecredit' => $UsedECredit,
//                     'new_balance' => $BalanceEWalletCredit,
//                 ]);

//                 throw new \Exception(
//                     'Invalid e-credit calculation.'
//                 );
//             }

        

//             $BalanceEWalletCredit =
//                 round($BalanceEWalletCredit, 2);

         
//             if (!is_finite($BalanceEWalletCredit)) {

//                 throw new \Exception(
//                     'Invalid e-credit calculation.'
//                 );
//             }

//             if ($BalanceEWalletCredit > $MaxECredit) {

//                 throw new \Exception(
//                     'Invalid e-credit calculation.'
//                 );
//             }

//         } else {

//             $BalanceEWalletCredit = $CurrentEWalletCredit;
//         }

    
//         $OrderNo = $Misc->getNextOrderNumberFormat();


//         $SalesHeaderID = DB::table('ecommerce_sales_headers')
//             ->insertGetId([
//                 'user_id' => $UserID,
//                 'order_number' => $OrderNo,
//                 'order_source' => $Platform,
//                 'customer_name' => $CustomerName,
//                 'customer_email' => $CustomerEmailAddress,
//                 'customer_contact_number' => $CustomerMobileNo,
//                 'customer_address' => $CompleteAddress,
//                 'customer_delivery_adress' => $CompleteDeliveryAddress,
//                 'customer_delivery_zip' => $ZipCode,
//                 'gross_amount' => $GrossAmount,
//                 'net_amount' => $NetAmount,
//                 'discount_amount' => $VoucherDiscountAmount,
//                 'payment_method' => $PaymentMethod,
//                 'payment_status' => $PaymentStatus,
//                 'ecredit_amount' => $UsedECredit,
//                 'delivery_type' => 'd2d',
//                 'delivery_status' => 'Delivered',
//                 'delivery_fee_amount' => 0,
//                 'delivery_fee_discount' => 0,
//                 'status' => 'Active',
//                 'created_at' => $TODAY
//             ]);

//         if (!$SalesHeaderID) {
//             throw new \Exception(
//                 'Unable to create sales order.'
//             );
//         }

     
//         $ReceiptNo = $Misc->GenerateRandomNo(
//             6,
//             'ecommerce_sales_headers',
//             'order_number'
//         );

//         $PaymentHeaderID = DB::table('ecommerce_sales_payments')
//             ->insertGetId([
//                 'sales_header_id' => $SalesHeaderID,
//                 'payment_type' => $PaymentMethod,
//                 'amount' => $NetAmount,
//                 'status' => $PaymentStatus,
//                 'payment_date' => $PaymentDate,
//                 'receipt_number' => $ReceiptNo,
//                 'created_by' => $UserID,
//                 'created_at' => $TODAY
//             ]);

//         if (!$PaymentHeaderID) {
//             throw new \Exception(
//                 'Unable to create payment record.'
//             );
//         }

       
//         if ($VoucherCode != '') {

//             $info = $Voucher->getVoucherInfoByCode($VoucherCode);

//             if ($info) {

//                 DB::table('coupon_sales')
//                     ->insertGetId([
//                         'customer_id' => $UserID,
//                         'coupon_id' => $info->coupon_ID,
//                         'coupon_code' => $VoucherCode,
//                         'sales_header_id' => $SalesHeaderID,
//                         'order_status' => $PaymentStatus,
//                         'created_at' => $TODAY
//                     ]);
//             }
//         }

       
//         foreach ($cart_info as $item_list) {

//             DB::table('ecommerce_sales_details')
//                 ->insertGetId([
//                     'sales_header_id' => $SalesHeaderID,
//                     'product_id' => $item_list->book_ID,
//                     'product_name' => $item_list->name,
//                     'product_category' => $item_list->category_id,
//                     'price' => $item_list->price,
//                     'qty' => 0,
//                     'uom' => $item_list->uom,
//                     'tax_amount' => 0,
//                     'promo_id' => 0,
//                     'promo_description' => '',
//                     'discount_amount' => $item_list->discount_amount,
//                     'gross_amount' => $GrossAmount,
//                     'net_amount' => $NetAmount,
//                     'created_by' => $UserID,
//                     'created_at' => $TODAY
//                 ]);

          
//             DB::table('customer_libraries')
//                 ->insertGetId([
//                     'user_id' => $UserID,
//                     'product_id' => $item_list->book_ID,
//                     'created_at' => $TODAY
//                 ]);
//         }

      

//         DB::table('ecommerce_shopping_cart')
//             ->where('user_id', $UserID)
//             ->delete();

     
//         if ($PaymentMethod == 'EWallet') {

        
//             DB::table('ecredits')
//                 ->insertGetId([
//                     'user_id' => $UserID,
//                     'used_credits' => $UsedECredit,
//                     'balance' => $BalanceEWalletCredit,
//                     'remarks' =>
//                         'Used ' .
//                         $UsedECredit .
//                         ' e-credit as payment for order no. ' .
//                         $OrderNo,
//                     'created_at' => $TODAY
//                 ]);

          
//             $updated = DB::table('users')
//                 ->where('id', $UserID)
//                 ->update([
//                     'ecredits' => $BalanceEWalletCredit,
//                     'updated_at' => $TODAY
//                 ]);

//             if (!$updated) {
//                 throw new \Exception(
//                     'Unable to update e-credit balance.'
//                 );
//             }
//         }

       
//         if ($PaymentMethod == 'PayPal') {

//             DB::table('paypal_payment')
//                 ->insertGetId([
//                     'user_id' => $UserID,
//                     'paypal_param_response' => $PayPalParamResponse,
//                     'sales_header_id' => $SalesHeaderID,
//                     'Status' => 'Success',
//                     'payment_date_time' => $TODAY
//                 ]);
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | COMMIT
//         |--------------------------------------------------------------------------
//         */

//         DB::commit();

//     } catch (\Throwable $e) {

      

//         DB::rollBack();

//         \Log::error(
//             'Checkout failed - transaction rolled back',
//             [
//                 'user_id' => $UserID,
//                 'payment_method' => $PaymentMethod,
//                 'used_ecredit' => $UsedECredit,
//                 'error' => $e->getMessage(),
//                 'file' => $e->getFile(),
//                 'line' => $e->getLine(),
//             ]
//         );

//         return $e->getMessage();
//     }

 
//     if ($SalesHeaderID > 0) {

//         try {

//             $OrderInfo = $this->getOrderInfo($SalesHeaderID);

//             if ($OrderInfo && $OrderInfo->SalesHeaderID > 0) {

//                 $param['OrderID'] =
//                     $OrderInfo->SalesHeaderID;

//                 $param['EmailAddress'] =
//                     $OrderInfo->customer_email;

//                 $param['MobileNo'] =
//                     $OrderInfo->customer_contact_number;

//                 $param['OrderNo'] =
//                     $OrderInfo->order_number;

//                 $param['OrderInfo'] =
//                     $OrderInfo;

//                 $param['OrderItem'] =
//                     $this->getOrderItemList($SalesHeaderID);

//                 $Email = new Email();

//                 $Email->SendOrderReceivedEmail($param);
//             }

//         } catch (\Throwable $e) {

         
//             \Log::error(
//                 'Order created but email failed',
//                 [
//                     'sales_header_id' => $SalesHeaderID,
//                     'order_number' => $OrderNo,
//                     'error' => $e->getMessage(),
//                 ]
//             );
//         }
//     }

//     return 'Success';
// }

 // function getOrderInfo($SalesHeaderID){
   
 //   $query = DB::table('ecommerce_sales_headers as sales_hdr')
 //     ->leftjoin('ecommerce_sales_payments as sales_pay', 'sales_pay.sales_header_id', '=', 'sales_hdr.id') 
 //       ->selectraw("
 //          sales_hdr.id as SalesHeaderID,
        
 //          COALESCE(sales_hdr.created_at,'') as order_date,
 //          DATE_FORMAT(sales_hdr.created_at,'%m/%d/%Y') as order_date_format,

 //          COALESCE(sales_hdr.order_number,'') as order_number,
 //          COALESCE(sales_hdr.order_source,'') as order_source,
 //          COALESCE(sales_hdr.customer_name,'') as customer_name,
          
 //          COALESCE(sales_hdr.customer_email,'') as customer_email,
 //          COALESCE(sales_hdr.customer_contact_number,'') as customer_contact_number,

 //          COALESCE(sales_hdr.customer_address,'') as customer_address,   

 //          COALESCE(sales_hdr.customer_delivery_adress,'') as customer_delivery_adress,                
 //          COALESCE(sales_hdr.customer_delivery_zip,'') as customer_delivery_zip,                
          
 //          COALESCE(sales_hdr.delivery_type,'') as delivery_type,          
 //          COALESCE(sales_hdr.delivery_fee_amount,0) as delivery_fee_amount,

 //          COALESCE(sales_hdr.gross_amount,0) as gross_amount,  
 //          COALESCE(sales_hdr.tax_amount,0) as tax_amount,
 //          COALESCE(sales_hdr.net_amount,0) as net_amount,
 //          COALESCE(sales_hdr.discount_amount,0) as discount_amount,

 //          COALESCE(sales_hdr.ecredit_amount,0) as ecredit_amount,
          
 //          COALESCE(sales_hdr.other_instruction,'') as order_instruction,
          
 //          COALESCE(sales_hdr.payment_status,'') as payment_status,        
 //          COALESCE(sales_hdr.other_instruction,'') as other_instruction,  

 //          COALESCE(sales_pay.payment_type,'') as payment_method,        
 //          COALESCE(sales_pay.amount,0) as payment_amount,        
 //          COALESCE(sales_pay.status,'') as payment_status,        
 //          COALESCE(sales_pay.receipt_number,'') as receipt_number,

 //          COALESCE(sales_hdr.status,'') as status          
          
 //        ");    

 //       $query->where("sales_hdr.id",'=',$SalesHeaderID);    
   
 //    $list = $query->first();
                             
 //    return $list;             
           
 //  }
  
 //   function getOrderItemList($SalesHeaderID){

 //    $query = DB::table('ecommerce_sales_details as sls_dtls')
 //           ->leftjoin('products as prod', 'prod.id', '=', 'sls_dtls.product_id') 
 //           ->leftjoin('subscriptions as subs', 'subs.id', '=', 'sls_dtls.subscription_plan_id') 

 //       ->selectraw("
 //          sls_dtls.id as SalesDetailID,
              
 //          COALESCE(sls_dtls.sales_header_id,0) as sales_header_id,          
 //          COALESCE(sls_dtls.product_id,0) as product_id,          
 //          COALESCE(sls_dtls.product_name,'') as product_name,
          
 //          COALESCE(sls_dtls.subscription_plan_id,0) as subscription_plan_id,
 //          COALESCE(subs.title,'') as plan_title,
 //          COALESCE(subs.short_description,'') as plan_description,
          
 //          COALESCE(sls_dtls.product_category,'') as product_category,
 //          COALESCE(sls_dtls.price,0) as price,
 //          COALESCE(sls_dtls.discount_amount,0) as discount_price,          

 //          COALESCE(prod.author,'') as author,
 //          COALESCE(prod.is_premium,0) as is_premium,

 //          COALESCE((
 //               SELECT 
 //                  prod_img.path FROM 
 //                      product_photos as prod_img                  
 //                  LEFT JOIN products as prods ON prods.id = prod_img.product_id
 //                      WHERE prod_img.product_id = sls_dtls.product_id
 //                      AND prod_img.is_primary = 1    
 //                  LIMIT 1                                
 //              )
 //        ,'') as image_path,

 //            COALESCE((
 //              SELECT ROUND(avg(rating))
 //                  FROM product_reviews as rev
 //                WHERE rev.product_id = sls_dtls.product_id     
 //                AND rev.status = 1 
 //             LIMIT 1                                
 //              )
 //        ,0) as rating
          
 //    ");    

 //    $query->where("sls_dtls.sales_header_id",'=',$SalesHeaderID);    
 //    $info = $query->get();
                             
 //    return $info;             
           
 //  }


function getOrderInfo($SalesHeaderID)
{
    $cacheKey = 'order_info_' . $SalesHeaderID;

    return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($SalesHeaderID) {

        $query = DB::table('ecommerce_sales_headers as sales_hdr')
            ->leftJoin(
                'ecommerce_sales_payments as sales_pay',
                'sales_pay.sales_header_id','=','sales_hdr.id'
            )
            ->selectRaw("
                sales_hdr.id as SalesHeaderID,

                COALESCE(sales_hdr.created_at,'') as order_date,
                DATE_FORMAT(sales_hdr.created_at,'%m/%d/%Y') as order_date_format,

                COALESCE(sales_hdr.order_number,'') as order_number,
                COALESCE(sales_hdr.order_source,'') as order_source,
                COALESCE(sales_hdr.customer_name,'') as customer_name,

                COALESCE(sales_hdr.customer_email,'') as customer_email,
                COALESCE(sales_hdr.customer_contact_number,'') as customer_contact_number,

                COALESCE(sales_hdr.customer_address,'') as customer_address,

                COALESCE(sales_hdr.customer_delivery_adress,'') as customer_delivery_adress,
                COALESCE(sales_hdr.customer_delivery_zip,'') as customer_delivery_zip,

                COALESCE(sales_hdr.delivery_type,'') as delivery_type,
                COALESCE(sales_hdr.delivery_fee_amount,0) as delivery_fee_amount,

                COALESCE(sales_hdr.gross_amount,0) as gross_amount,
                COALESCE(sales_hdr.tax_amount,0) as tax_amount,
                COALESCE(sales_hdr.net_amount,0) as net_amount,
                COALESCE(sales_hdr.discount_amount,0) as discount_amount,

                COALESCE(sales_hdr.ecredit_amount,0) as ecredit_amount,

                COALESCE(sales_hdr.other_instruction,'') as order_instruction,

                COALESCE(sales_hdr.payment_status,'') as payment_status,
                COALESCE(sales_hdr.other_instruction,'') as other_instruction,

                COALESCE(sales_pay.payment_type,'') as payment_method,
                COALESCE(sales_pay.amount,0) as payment_amount,
                COALESCE(sales_pay.status,'') as payment_status,
                COALESCE(sales_pay.receipt_number,'') as receipt_number,

                COALESCE(sales_hdr.status,'') as status
            ")
            ->where('sales_hdr.id', '=', $SalesHeaderID);

        return $query->first();
    });
}


// function getOrderItemList($SalesHeaderID)
// {
//     $cacheKey = 'order_items_' . $SalesHeaderID;

//     return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($SalesHeaderID) {

//         $query = DB::table('ecommerce_sales_details as sls_dtls')
//             ->leftJoin('products as prod', 'prod.id', '=', 'sls_dtls.product_id')
  
//             ->selectRaw("
//                 sls_dtls.id as SalesDetailID,

//                 COALESCE(sls_dtls.sales_header_id,0) as sales_header_id,
//                 COALESCE(sls_dtls.product_id,0) as product_id,
//                 COALESCE(sls_dtls.product_name,'') as product_name,

//                 COALESCE(sls_dtls.subscription_plan_id,0) as subscription_plan_id,
      
//                 COALESCE(sls_dtls.product_category,'') as product_category,
//                 COALESCE(sls_dtls.price,0) as price,
//                 COALESCE(sls_dtls.discount_amount,0) as discount_price,

//                 COALESCE(prod.author,'') as author,
//                 COALESCE(prod.is_premium,0) as is_premium,

//                 COALESCE((
//                     SELECT prod_img.path
//                     FROM product_photos as prod_img
//                     LEFT JOIN products as prods
//                         ON prods.id = prod_img.product_id
//                     WHERE prod_img.product_id = sls_dtls.product_id
//                     AND prod_img.is_primary = 1
//                     LIMIT 1
//                 ),'') as image_path,

//                 COALESCE((
//                     SELECT ROUND(AVG(rating))
//                     FROM product_reviews as rev
//                     WHERE rev.product_id = sls_dtls.product_id
//                     AND rev.status = 1
//                     LIMIT 1
//                 ),0) as rating
//             ")
//             ->where('sls_dtls.sales_header_id', '=', $SalesHeaderID);

//         return $query->get();
//     });
// }

function getOrderItemList($SalesHeaderID)
{
    $cacheKey = 'order_items_' . $SalesHeaderID;
    return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($SalesHeaderID) {
        $query = DB::table('ecommerce_sales_details as sls_dtls')
            ->leftJoin('products as prod', 'prod.id', '=', 'sls_dtls.product_id')
            ->leftJoin('vw_product_primary_image as img', 'img.product_id', '=', 'sls_dtls.product_id')
            ->leftJoin('vw_product_rating as rt', 'rt.product_id', '=', 'sls_dtls.product_id')
            ->selectRaw("
                sls_dtls.id as SalesDetailID,
                COALESCE(sls_dtls.sales_header_id,0) as sales_header_id,
                COALESCE(sls_dtls.product_id,0) as product_id,
                COALESCE(sls_dtls.product_name,'') as product_name,
                COALESCE(sls_dtls.product_category,'') as product_category,
                COALESCE(sls_dtls.price,0) as price,
                COALESCE(sls_dtls.discount_amount,0) as discount_price,
                COALESCE(prod.author,'') as author,
                COALESCE(prod.is_premium,0) as is_premium,
                COALESCE(img.image_path,'') as image_path,
                COALESCE(rt.rating,0) as rating
            ")
            ->where('sls_dtls.sales_header_id', '=', $SalesHeaderID)
            ->limit(15);
        return $query->get();
    });
}
  
//   public function getOrderHistoryItemList($UserID)
// {
//     $cacheKey = 'order_history_items_' . $UserID;

//     $list = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($UserID) {

//         $query = DB::table('ecommerce_sales_details as sls_dtls')
//             ->leftJoin(
//                 'ecommerce_sales_headers as sales_hdr',
//                 'sales_hdr.id',
//                 '=',
//                 'sls_dtls.sales_header_id'
//             )
//             ->selectRaw("
//                 COALESCE(sls_dtls.product_name,'') as product_name,

//                 COALESCE(sls_dtls.price,0) as price,
//                 COALESCE(sls_dtls.discount_amount,0) as discount_price,

//                 COALESCE(sls_dtls.gross_amount,0) as gross_amount,
//                 COALESCE(sls_dtls.net_amount,0) as net_amount,

//                 COALESCE(sales_hdr.created_at,'') as order_date,
//                 DATE_FORMAT(sales_hdr.created_at,'%m/%d/%Y') as order_date_format,

//                 COALESCE(sales_hdr.order_number,'') as order_number,
//                 COALESCE(sales_hdr.order_source,'') as order_source,
//                 COALESCE(sales_hdr.customer_name,'') as customer_name,

//                 COALESCE(sales_hdr.customer_email,'') as customer_email,
//                 COALESCE(sales_hdr.customer_contact_number,'') as customer_contact_number,

//                 COALESCE(sales_hdr.customer_address,'') as customer_address
//             ")
//             ->where('sales_hdr.user_id', '=', $UserID);

//         return $query->get();
//     });

//     return $list;
// }

public function getOrderHistoryItemList($UserID)
{
    $cacheKey = 'order_history_items_' . $UserID;
    $list = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($UserID) {
        $query = DB::table('ecommerce_sales_details as sls_dtls')
            ->leftJoin(
                'ecommerce_sales_headers as sales_hdr',
                'sales_hdr.id',
                '=',
                'sls_dtls.sales_header_id'
            )
            ->selectRaw("
                COALESCE(sls_dtls.product_name,'') as product_name,
                COALESCE(sls_dtls.price,0) as price,
                COALESCE(sls_dtls.discount_amount,0) as discount_price,
                COALESCE(sls_dtls.gross_amount,0) as gross_amount,
                COALESCE(sls_dtls.net_amount,0) as net_amount,
                COALESCE(sales_hdr.created_at,'') as order_date,
                DATE_FORMAT(sales_hdr.created_at,'%m/%d/%Y') as order_date_format,
                COALESCE(sales_hdr.order_number,'') as order_number,
                COALESCE(sales_hdr.order_source,'') as order_source,
                COALESCE(sales_hdr.customer_name,'') as customer_name,
                COALESCE(sales_hdr.customer_email,'') as customer_email,
                COALESCE(sales_hdr.customer_contact_number,'') as customer_contact_number,
                COALESCE(sales_hdr.customer_address,'') as customer_address
            ")
            ->where('sales_hdr.user_id', '=', $UserID)
            ->limit(25);
        return $query->get();
    });
    return $list;
}


}
