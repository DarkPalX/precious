<?php

namespace App\Http\Controllers\Ecommerce;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Mail\DeliveryStatusMail;
use Illuminate\Support\Facades\Mail;

use App\Helpers\{ListingHelper, Setting, PaynamicsHelper, XDEHelper, LBCHelper};

use App\Models\Ecommerce\{
    Cart, SalesHeader, SalesDetail, SalesPayment, CustomerAddress, CustomerFavorite, CustomerWishlist, Product
};

use App\Models\{
    Page, User, Subscription, UsersSubscription, Ecredit
};

use App\Models\APIModels\{
    Order, Misc, Email
};


use Auth;
use DB;

class MyAccountController extends Controller
{
    public function dashboard(Request $request)
    {
        $page = new Page;
        $page->name = 'Dashboard';
        $sales = SalesHeader::where('user_id',Auth::id())->orderBy('id','desc')->paginate(10);

        $member = auth()->user();
        $user = auth()->user();

        $additional_addresses = CustomerAddress::where('user_id', $user->id)->get();

        return view('theme.pages.customer.dashboard', compact('member', 'user', 'page', 'additional_addresses', 'sales'));
    }

    public function manage_account(Request $request)
    {
        $page = new Page;
        $page->name = 'My Account';

        $member = auth()->user();
        $user = auth()->user();

        $additional_addresses = CustomerAddress::where('user_id', $user->id)->get();

        return view('theme.pages.customer.manage-account', compact('member', 'user', 'page', 'additional_addresses'));
    }

    public function deactivate_social_login(Request $request)
    {
        $page = new Page;
        $page->name = 'Social Login Deactivated';

        User::where('id', $request->user_id)
        ->update([
            'social_login' => 0,
            'is_active' => 0
        ]);

        Auth::logout();

        return view('theme.pages.customer.social-login-deactivation', compact('page'));
    }

    public function library(Request $request)
    {
        $page = new Page;
        $page->name = 'My Library';

        $member = auth()->user();
        $user = auth()->user();

        $additional_addresses = CustomerAddress::where('user_id', $user->id)->get();

        return view('theme.pages.customer.library', compact('member', 'user', 'page', 'additional_addresses'));
    }

    public function wishlist(Request $request)
    {
        $page = new Page;
        $page->name = 'My Wishlist';

        $member = auth()->user();
        $user = auth()->user();
        $pageLimit = 12;

        $customer_wishlists = Product::select('products.*')
        ->leftJoin('product_additional_infos', 'products.id', '=', 'product_additional_infos.product_id')
        ->where('products.status', 'PUBLISHED')
        ->join('customer_wishlists', 'customer_wishlists.product_id', '=', 'products.id')
        ->where('customer_wishlists.customer_id', auth()->id());

        $searchtxt = $request->get('keyword', false);
        $sortBy = $request->get('sort_by', false);

        if(!empty($searchtxt)){  
            $keyword = Str::lower($request->keyword); 

            $customer_wishlists = $customer_wishlists->where(function($query) use ($keyword){
                $query->orWhereRaw('LOWER(products.name) like LOWER(?)', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(products.author) like LOWER(?)', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(products.description) like LOWER(?)', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(product_additional_infos.value) like LOWER(?)', ["%{$keyword}%"]);
            });
        }

        if($sortBy == "name_asc"){
            $customer_wishlists = $customer_wishlists->orderBy('name','asc')->paginate($pageLimit);
        }
        elseif($sortBy == "name_desc"){
            $customer_wishlists = $customer_wishlists->orderBy('name','desc')->paginate($pageLimit);
        }
        elseif($sortBy == "price_asc"){
            $customer_wishlists = $customer_wishlists->orderBy('price','asc')->paginate($pageLimit);
        }
        elseif($sortBy == "price_desc"){
            $customer_wishlists = $customer_wishlists->orderBy('price','desc')->paginate($pageLimit);
        }
        elseif($sortBy == "date_asc"){
            $customer_wishlists = $customer_wishlists->orderBy('created_at','asc')->paginate($pageLimit);
        }
        elseif($sortBy == "date_desc"){
            $customer_wishlists = $customer_wishlists->orderBy('created_at','desc')->paginate($pageLimit);
        }
        else{
            $customer_wishlists = $customer_wishlists->orderBy('name','asc')->paginate($pageLimit);
        }


        return view('theme.pages.customer.wishlist', compact('member', 'user', 'page', 'customer_wishlists'));
    }

    public function favorites(Request $request)
    {
        $page = new Page;
        $page->name = 'My Favorites';

        $member = auth()->user();
        $user = auth()->user();
        $pageLimit = 12;

        $customer_favorites = Product::select('products.*')
        ->leftJoin('product_additional_infos', 'products.id', '=', 'product_additional_infos.product_id')
        ->where('products.status', 'PUBLISHED')
        ->join('customer_favorites', 'customer_favorites.product_id', '=', 'products.id')
        ->where('customer_favorites.customer_id', auth()->id());

        $searchtxt = $request->get('keyword', false);
        $sortBy = $request->get('sort_by', false);

        if(!empty($searchtxt)){  
            $keyword = Str::lower($request->keyword); 

            $customer_favorites = $customer_favorites->where(function($query) use ($keyword){
                $query->orWhereRaw('LOWER(products.name) like LOWER(?)', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(products.author) like LOWER(?)', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(products.description) like LOWER(?)', ["%{$keyword}%"])
                ->orWhereRaw('LOWER(product_additional_infos.value) like LOWER(?)', ["%{$keyword}%"]);
            });
        }

        if($sortBy == "name_asc"){
            $customer_favorites = $customer_favorites->orderBy('name','asc')->paginate($pageLimit);
        }
        elseif($sortBy == "name_desc"){
            $customer_favorites = $customer_favorites->orderBy('name','desc')->paginate($pageLimit);
        }
        elseif($sortBy == "price_asc"){
            $customer_favorites = $customer_favorites->orderBy('price','asc')->paginate($pageLimit);
        }
        elseif($sortBy == "price_desc"){
            $customer_favorites = $customer_favorites->orderBy('price','desc')->paginate($pageLimit);
        }
        elseif($sortBy == "date_asc"){
            $customer_favorites = $customer_favorites->orderBy('created_at','asc')->paginate($pageLimit);
        }
        elseif($sortBy == "date_desc"){
            $customer_favorites = $customer_favorites->orderBy('created_at','desc')->paginate($pageLimit);
        }
        else{
            $customer_favorites = $customer_favorites->orderBy('name','asc')->paginate($pageLimit);
        }


        return view('theme.pages.customer.favorites', compact('member', 'user', 'page', 'customer_favorites'));
    }

    // public function favorites(Request $request)
    // {
    //     $page = new Page;
    //     $page->name = 'My Favorites';

    //     $member = auth()->user();
    //     $user = auth()->user();

    //     $customer_favorites = CustomerFavorite::where('customer_id', auth()->user()->id ?? -1)
    //     ->with('product') // Eager load the related product
    //     ->get();

    //     return view('theme.pages.customer.favorites', compact('member', 'user', 'page', 'customer_favorites'));
    // }

    public function free_ebooks(Request $request)
    {
        $page = new Page;
        $page->name = 'Free E-books';

        $member = auth()->user();
        $user = auth()->user();

        $additional_addresses = CustomerAddress::where('user_id', $user->id)->get();

        return view('theme.pages.customer.free-ebooks', compact('member', 'user', 'page', 'additional_addresses'));
    }

    public function ecredits(Request $request)
    {
        $page = new Page;
        $page->name = 'E-Credits';

        $member = auth()->user();
        $user = auth()->user();

        $additional_addresses = CustomerAddress::where('user_id', $user->id)->get();

        return view('theme.pages.customer.ecredits', compact('member', 'user', 'page', 'additional_addresses'));
    }

    public function update_personal_info(Request $request)
    {
        $requestData = $request->except(['_token', 'additional_address']);
        $requestData['name'] = $request->firstname.' '.$request->lastname;

        User::whereId((int) Auth::id())->update($requestData);

        
        $user_exists = CustomerAddress::where('user_id', Auth::id())->first();

        if($user_exists){
            CustomerAddress::where('user_id', Auth::id())->delete();
        }
        
        if($request->additional_address){
            foreach($request->additional_address as $additional_add){

                $additionalInfo['user_id'] = auth()->user()->id;
                $additionalInfo['additional_address'] = $additional_add;

                CustomerAddress::create($additionalInfo);
            }
        }

        return redirect()->back()->with('success', 'Account details has been updated');
    }

    public function change_password()
    {
        $page = new Page();
        $page->name = 'Change Password';

        return view('theme.pages.customer.change-password',compact('page'));
    }

    public function update_password(Request $request)
    {
        $personalInfo = $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!\Hash::check($value, auth()->user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }],
            'password' => [
                'required',
                'min:8',
                'max:150', 
                'regex:/[a-z]/', // must contain at least one lowercase letter
                'regex:/[A-Z]/', // must contain at least one uppercase letter
                'regex:/[0-9]/', // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character              
            ],
            'confirm_password' => 'required|same:password',
        ]);

        auth()->user()->update(['password' => bcrypt($personalInfo['password'])]);

        return back()->with('success', 'Password has been updated');
    }


    public function orders(){

        $sales = SalesHeader::where('user_id',Auth::id())->orderBy('id','desc')->paginate(10);
        foreach($sales as $sale){
            $sale->updateOrderStatus();
        }
        $sales = SalesHeader::where('user_id',Auth::id())->orderBy('id','desc')->paginate(10);

        $page = new Page();
        $page->name = 'Sales Transaction';

        return view('theme.pages.customer.orders',compact('sales','page'));
    }

    public function cancel_order(Request $request){

        $sales = SalesHeader::find($request->orderid);
        $sales->update([
            'cancellation_request' => 1,
            'cancellation_reason' => $request->reason,
            'cancellation_remarks' => $request->remarks,
            'delivery_status' => 'CANCELLED',
            'status' => 'CANCELLED'
        ]);

        Mail::to(Auth::user())->send(new DeliveryStatusMail($sales, Setting::info()));  

        return back()->with('success','Order #:'.$sales->order_number.' has been cancelled.');
    }

    // public function cancel_order(Request $request){

    //     $sales = SalesHeader::find($request->orderid);
    //     $sales->update(['status' => 'CANCELLED', 'delivery_status' => 'CANCELLED']);

    //     return back()->with('success','Order #:'.$sales->order_number.' has been cancelled.');
    // }

    public function pay_again($id){
        $r = SalesHeader::findOrFail($id);

        $urls = [
            'notification' => route('cart.payment-notification'),
            'result' => route('profile.sales'),
            'cancel' => route('profile.sales'),
        ];

        $totalDiscountedPrice = $r->gross_amount-$r->discount_amount;

        $base64Code = PaynamicsHelper::payNow($r->id, Auth::user(), number_format($totalDiscountedPrice, 2, '.', ''), $urls, false, number_format($r->delivery_fee_amount, 2, '.', ''), number_format($r->discount_amount, 2, '.', ''), number_format($r->delivery_fee_discount, 2, '.', ''));

        return view('theme.paynamics.sender', compact('base64Code'));
    }






    // SUBSCRIPTIONS
    
    public function subscription()
    {
        $page = new Page;
        $page->name = 'Subscription';

        $member = auth()->user();
        $user = auth()->user();

        $subscriptions = Subscription::where('status', 'Active')->get();
        $current_subscription = UsersSubscription::where('user_id', Auth::user()->id)->where('is_subscribe', 1)->first();

        if($current_subscription){
            $subscription_detail = Subscription::where('id', $current_subscription->plan_id)->first();
            return view('theme.pages.customer.subscription', compact('member', 'user', 'page', 'subscriptions', 'current_subscription', 'subscription_detail'));
        }
        else{
            return view('theme.pages.customer.subscription', compact('member', 'user', 'page', 'subscriptions', 'current_subscription'));
        }

    }
    
    public function subscription_selected(Request $request)
    {
        $page = new Page;
        $page->name = 'Subscription';

        $member = auth()->user();
        $user = auth()->user();

        $subscription = Subscription::find($request->subscription_id);

        return view('theme.pages.customer.subscription-selected', compact('member', 'user', 'page', 'subscription'));
    }
    
    public function subscription_checkout(Request $request)
    {
        $user_id = Auth::user()->id;
        $mode_payment = $request->mode_payment;
        $amount_paid = $request->amount_paid;

        if ($mode_payment == 'PayPal') {
            // Store the entire request data in the session
            session(['paypal_request' => $request->all()]);

            // Redirect to PayPal
            return redirect()->route('paypal.create', [
                'transaction' => 'subscription',
                'user_id' => $user_id,
                'amount_paid' => $amount_paid
            ]);
        }

        return $this->subscription_process($request);
    }


    public static function subscription_process(Request $request)
    {
        $Misc  = New Misc();
        
        $user_id = Auth::user()->id;
        $plan_id = $request->plan_id;
        $title = $request->title;
        $no_days = $request->no_days;
        $mode_payment = $request->mode_payment;
        $amount_paid = $request->amount_paid;
        $start_date = date("Y-m-d H:i:s");
        $end_date = date('Y-m-d H:i:s', strtotime("+".$no_days." day"));

        $customer_name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
        $customer_email = Auth::user()->email;
        $customer_contact_number = Auth::user()->mobile;
        $customer_address = Auth::user()->address_street . ', ' . Auth::user()->address_city . ', ' . Auth::user()->address_municipality . ', ' . Auth::user()->address_province . ' ' . Auth::user()->address_zip;
        $customer_delivery_zip = Auth::user()->address_zip;

        $message = '';

        $currently_subscribed = UsersSubscription::where('user_id', $user_id)->where('is_subscribe', 1)->first();

        // dd($currently_subscribed);

        if(!$currently_subscribed){
            $user_subscription = UsersSubscription::create([
                'user_id' => $user_id,                                                                          
                'plan_id' => $plan_id, 
                'no_days' => $no_days, 
                'mode_payment' => $mode_payment, 
                'amount_paid' => $amount_paid,           
                'start_date' => $start_date, 
                'end_date' => $end_date,
                'is_subscribe' => 1, 
                'remarks' => 'Set a '.$no_days.' days subscription plan with plan ID:'.$plan_id     
            ]);

            $message = 'You have successfully subscribed to a '.$title. " plan & it will expire on ".$end_date. " .";
        }
        else{

            $new_date_extended=date_create($currently_subscribed->end_date);
            date_add($new_date_extended,date_interval_create_from_date_string($no_days." days"));            
            $new_end_date=date("Y-m-d H:i:s", strtotime(date_format($new_date_extended,"Y-m-d H:i:s")));

            UsersSubscription::where('id', $currently_subscribed->id)
            ->update([
                'plan_id' => $plan_id, 
                'no_days' => $currently_subscribed->no_days + $no_days, 
                'mode_payment' => $mode_payment, 
                'amount_paid' => $amount_paid,           
                'end_date' => $new_end_date,
                'is_extended' => 1, 
                'remarks' => 'Extended a '.$no_days.' days subscription plan with plan ID:'.$plan_id
            ]);

            $message = 'You have successfully extended your current plan to a '.$no_days. " days subscription & will expire on ".$end_date. " .";
            
        }

        //Send Notification Message
        $messaage_notification = DB::table('message_notification')
        ->insertGetId([                                            
            'user_id' => $user_id,                                                         
            'message_notification' => $message,
            'created_at' => $start_date             
        ]);  

        // SALES HEADER
        $order_no = $Misc->getNextOrderNumberFormat();      
        $sales_header = SalesHeader::create([                                            
          'user_id' => $user_id,              
          'order_number' => $order_no,                                            
          'customer_name' => $customer_name, 
          'customer_email' => $customer_email, 
          'customer_contact_number' => $customer_contact_number, 
          'customer_address' => $customer_address, 
          'customer_delivery_adress' => $customer_address, 
          'customer_delivery_zip' => $customer_delivery_zip,                           
          'gross_amount' => $amount_paid, 
          'net_amount' => $amount_paid, 
          'discount_amount' => 0, 
          'payment_method' => $mode_payment,
          'payment_status' => 'PAID', 
          'ecredit_amount' => $amount_paid, 
          'delivery_type' => 'd2d', 
          'delivery_status' => 'Delivered', 
          'delivery_fee_amount' => 0, 
          'delivery_fee_discount' => 0, 
          'status' => 'Active', 
        ]);


        if($sales_header){
            //SAVE TO SALES PAYMENT
            $receipt_number = $Misc->GenerateRandomNo(6,'ecommerce_sales_headers','order_number'); 

            $sales_payment = SalesPayment::create([                                             
                'sales_header_id' => $sales_header->id,              
                'payment_type' => $mode_payment,                                            
                'amount' => $amount_paid,                                            
                'status' => 'PAID', 
                'payment_date' => $start_date, 
                'receipt_number' => $receipt_number,
                'created_by' => $user_id,         
            ]); 

            $sales_detail = SalesDetail::create([                 
                'sales_header_id' => $sales_header->id,              
                'product_id' => 0,        
                'subscription_plan_id' => $plan_id,              
                'product_name' => $title, 
                'product_category' =>0,              
                'price' => $amount_paid,              
                'qty' => 1, 
                'uom' => '', 
                'tax_amount' => 0,              
                'promo_id' => 0,  
                'promo_description' => '',  
                'tax_amount' => 0,  
                'discount_amount' => 0,                        
                'gross_amount' => $amount_paid,                                                        
                'net_amount' => $amount_paid,
                'created_by' => $user_id,                        
            ]); 


            // SEND EMAIL NOTIFICATION
            $Order= new Order();
            $OrderInfo= $Order->getOrderInfo($sales_header->id);        
            if($OrderInfo->SalesHeaderID>0){
                $param['OrderID']=$OrderInfo->SalesHeaderID;
                $param['EmailAddress']=$OrderInfo->customer_email;
                $param["MobileNo"] = $OrderInfo->customer_contact_number;
                $param['OrderNo']=$OrderInfo->order_number;        
                $param['OrderInfo']=$OrderInfo;
                $param['OrderItem']=$Order->getOrderItemList($sales_header->id);
                
                $Email = new Email();
                $Email->SendOrderReceivedEmail($param);    
            }

            // RESUME & RETUEN SUBSBRIBED BOOKS===
            DB::table('subscribed_books')
              ->where('user_id',$user_id)              
              ->update([                                  
                'deleted_at' => null
            ]);
            

            // PAYMENT METHOD
            if($mode_payment == 'EWallet'){
                if($amount_paid > 0){

                   //UPDATE CURRENT BALANCE EWALLET
                    $ecredit = Ecredit::create([                                          
                        'user_id' => $user_id,              
                        'used_credits' => $amount_paid,                                              
                        'balance' => Auth::user()->ecredits - $amount_paid,  
                        'remarks' => 'Used '. $amount_paid .' e-credit as payment for subscription with order no. '. $order_no
                    ]); 
            
                    User::where('id',$user_id)
                    ->update([                              
                        'ecredits' => Auth::user()->ecredits - $amount_paid                                                         
                    ]);  
                            
                }
            }
            
            if($mode_payment == 'PayPal'){
                // Update
                DB::table('paypal_payment')->where('id', session('paypal_payment_id'))
                ->update([
                    'sales_header_id' => $sales_header->id,
                ]);

                session()->forget(['paypal_payment_id']);
            }

            return redirect()->route('home')->with('success', 'You have successfully subscribed a plan');
        }
        else{
            return redirect()->back()->with('error', 'Failed to process the subscription.');
        }
        
    }
    
    // public function subscription_checkout(Request $request)
    // {

    //     $Misc  = New Misc();
        
    //     $user_id = Auth::user()->id;
    //     $plan_id = $request->plan_id;
    //     $title = $request->title;
    //     $no_days = $request->no_days;
    //     $mode_payment = $request->mode_payment;
    //     $amount_paid = $request->amount_paid;
    //     $start_date = date("Y-m-d H:i:s");
    //     $end_date = date('Y-m-d H:i:s', strtotime("+".$no_days." day"));

    //     $customer_name = Auth::user()->firstname . ' ' . Auth::user()->lastname;
    //     $customer_email = Auth::user()->email;
    //     $customer_contact_number = Auth::user()->mobile;
    //     $customer_address = Auth::user()->address_street . ', ' . Auth::user()->address_city . ', ' . Auth::user()->address_municipality . ', ' . Auth::user()->address_province . ' ' . Auth::user()->address_zip;
    //     $customer_delivery_zip = Auth::user()->address_zip;

    //     $message = '';

    //     $currently_subscribed = UsersSubscription::where('user_id', $user_id)->where('is_subscribe', 1)->first();

    //     // dd($currently_subscribed);

    //     if(!$currently_subscribed){
    //         $user_subscription = UsersSubscription::create([
    //             'user_id' => $user_id,                                                                          
    //             'plan_id' => $plan_id, 
    //             'no_days' => $no_days, 
    //             'mode_payment' => $mode_payment, 
    //             'amount_paid' => $amount_paid,           
    //             'start_date' => $start_date, 
    //             'end_date' => $end_date,
    //             'is_subscribe' => 1, 
    //             'remarks' => 'Set a '.$no_days.' days subscription plan with plan ID:'.$plan_id     
    //         ]);

    //         $message = 'You have successfully subscribed to a '.$title. " plan & it will expire on ".$end_date. " .";
    //     }
    //     else{

    //         $new_date_extended=date_create($currently_subscribed->end_date);
    //         date_add($new_date_extended,date_interval_create_from_date_string($no_days." days"));            
    //         $new_end_date=date("Y-m-d H:i:s", strtotime(date_format($new_date_extended,"Y-m-d H:i:s")));

    //         UsersSubscription::where('id', $currently_subscribed->id)
    //         ->update([
    //             'plan_id' => $plan_id, 
    //             'no_days' => $currently_subscribed->no_days + $no_days, 
    //             'mode_payment' => $mode_payment, 
    //             'amount_paid' => $amount_paid,           
    //             'end_date' => $new_end_date,
    //             'is_extended' => 1, 
    //             'remarks' => 'Extended a '.$no_days.' days subscription plan with plan ID:'.$plan_id
    //         ]);

    //         $message = 'You have successfully extended your current plan to a '.$no_days. " days subscription & will expire on ".$end_date. " .";
            
    //     }

    //     //Send Notification Message
    //     $messaage_notification = DB::table('message_notification')
    //     ->insertGetId([                                            
    //         'user_id' => $user_id,                                                         
    //         'message_notification' => $message,
    //         'created_at' => $start_date             
    //     ]);  

    //     // SALES HEADER
    //     $order_no = $Misc->getNextOrderNumberFormat();      
    //     $sales_header = SalesHeader::create([                                            
    //       'user_id' => $user_id,              
    //       'order_number' => $order_no,                                            
    //       'customer_name' => $customer_name, 
    //       'customer_email' => $customer_email, 
    //       'customer_contact_number' => $customer_contact_number, 
    //       'customer_address' => $customer_address, 
    //       'customer_delivery_adress' => $customer_address, 
    //       'customer_delivery_zip' => $customer_delivery_zip,                           
    //       'gross_amount' => $amount_paid, 
    //       'net_amount' => $amount_paid, 
    //       'discount_amount' => 0, 
    //       'payment_method' => $mode_payment,
    //       'payment_status' => 'PAID', 
    //       'ecredit_amount' => $amount_paid, 
    //       'delivery_type' => 'd2d', 
    //       'delivery_status' => 'Delivered', 
    //       'delivery_fee_amount' => 0, 
    //       'delivery_fee_discount' => 0, 
    //       'status' => 'Active', 
    //     ]);


    //     if($sales_header){
    //         //SAVE TO SALES PAYMENT
    //         $receipt_number = $Misc->GenerateRandomNo(6,'ecommerce_sales_headers','order_number'); 

    //         $sales_payment = SalesPayment::create([                                             
    //             'sales_header_id' => $sales_header->id,              
    //             'payment_type' => $mode_payment,                                            
    //             'amount' => $amount_paid,                                            
    //             'status' => 'PAID', 
    //             'payment_date' => $start_date, 
    //             'receipt_number' => $receipt_number,
    //             'created_by' => $user_id,         
    //         ]); 

    //         $sales_detail = SalesDetail::create([                 
    //             'sales_header_id' => $sales_header->id,              
    //             'product_id' => 0,        
    //             'subscription_plan_id' => $plan_id,              
    //             'product_name' => $title, 
    //             'product_category' =>0,              
    //             'price' => $amount_paid,              
    //             'qty' => 1, 
    //             'uom' => '', 
    //             'tax_amount' => 0,              
    //             'promo_id' => 0,  
    //             'promo_description' => '',  
    //             'tax_amount' => 0,  
    //             'discount_amount' => 0,                        
    //             'gross_amount' => $amount_paid,                                                        
    //             'net_amount' => $amount_paid,
    //             'created_by' => $user_id,                        
    //         ]); 


    //         // SEND EMAIL NOTIFICATION
    //         $Order= new Order();
    //         $OrderInfo= $Order->getOrderInfo($sales_header->id);        
    //         if($OrderInfo->SalesHeaderID>0){
    //             $param['OrderID']=$OrderInfo->SalesHeaderID;
    //             $param['EmailAddress']=$OrderInfo->customer_email;
    //             $param["MobileNo"] = $OrderInfo->customer_contact_number;
    //             $param['OrderNo']=$OrderInfo->order_number;        
    //             $param['OrderInfo']=$OrderInfo;
    //             $param['OrderItem']=$Order->getOrderItemList($sales_header->id);
                
    //             $Email = new Email();
    //             $Email->SendOrderReceivedEmail($param);    
    //         }

    //         // RESUME & RETUEN SUBSBRIBED BOOKS===
    //         DB::table('subscribed_books')
    //           ->where('user_id',$user_id)              
    //           ->update([                                  
    //             'deleted_at' => null
    //         ]);
            

    //         // PAYMENT METHOD
    //         if($mode_payment == 'EWallet'){
    //             if($amount_paid > 0){

    //                //UPDATE CURRENT BALANCE EWALLET
    //                 $ecredit = Ecredit::create([                                          
    //                     'user_id' => $user_id,              
    //                     'used_credits' => $amount_paid,                                              
    //                     'balance' => Auth::user()->ecredits - $amount_paid,  
    //                     'remarks' => 'Used '. $amount_paid .' e-credit as payment for subscription with order no. '. $order_no
    //                 ]); 
            
    //                 User::where('id',$user_id)
    //                 ->update([                              
    //                     'ecredits' => Auth::user()->ecredits - $amount_paid                                                         
    //                 ]);  
                            
    //             }
    //         }
    //         else if($mode_payment=='PayPal'){

    //             // Redirect to PayPal with payment details
    //             return redirect()->route('paypal.create', [
    //                 'user_id' => $user_id,
    //                 'sales_header_id' => $sales_header->id,
    //                 'amount_paid' => $amount_paid
    //             ]);

    //         }  
    //     }

    //     return redirect()->route('product.front.list')->with('success', 'You have successfully subscribed a plan');
    // }
    
    public function subscription_cancel(Request $request)
    {

        $currently_subscribed = UsersSubscription::where('user_id', Auth::user()->id)->where('is_subscribe', 1)->first();

        if($currently_subscribed){
            UsersSubscription::where('id', $currently_subscribed->id)
            ->update([
                'is_subscribe' => 0,                                                 
                'is_expired' => 1,                                                          
                'is_cancelled' => 1,                                                          
                'cancel_reason' => $request->cancel_reason, 
                'remarks' => 'Cancel a '.$currently_subscribed->no_days.' days subscription plan with plan ID:'.$currently_subscribed->plan_id, 
            ]);
            
            //Dalete All Subscribed Read Books after Cancelled Subscription
            DB::table('subscribed_books')
                ->where('user_id', Auth::user()->id)              
                ->update([                                  
                'deleted_at' => date("Y-m-d H:i:s")
            ]);  
    
            //send cancel notif 
            $MessageNotificationID = DB::table('message_notification')
                ->insertGetId([                                            
                'user_id' => Auth::user()->id,                                                         
                'message_notification' => "Your current and active subscription plan has successfully cancelled & will end today ". date("Y-m-d H:i:s") . ".",                
                'created_at' => date("Y-m-d H:i:s")           
            ]);  
        }

        return redirect()->back()->with('success', 'You have successfully unsubscribed a plan');
    }

}
