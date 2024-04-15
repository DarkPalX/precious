<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// check and test api status
Route::get('/test', function(){
    return response([
            'message' => 'Api is working...'
     ], 200);

 });

// CUSTOMER CONTROLLER===========================================

//Customer Logout
Route::get('/logout',[
   'uses'=>'ApiController@doCheckLogin',
   'as'=> 'logout'
]);

//Customer Login
Route::post('/check-login',[
   'uses'=>'ApiController@doCheckLogin',
   'as'=> 'check-login'
]);

//Register New Customer Account
Route::post('/register-account',[
   'uses'=>'ApiController@doRegisterCustomer',
   'as'=> 'register-account'
]);

//Customer Forgot Password
Route::post('/forgot-password',[
   'uses'=>'ApiController@doForgotPassword',
   'as'=> 'forgot-password'
]);

//Customer Forgot Password
Route::post('/change-password',[
   'uses'=>'ApiController@doChangePassword',
   'as'=> 'change-password'
]);

//Customer Verify Account
Route::post('/verify-account',[
   'uses'=>'ApiController@doVerifyAccount',
   'as'=> 'verify-account'
]);

//Resend Verification Code
Route::post('/resend-code',[
   'uses'=>'ApiController@doResendVerificationCode',
   'as'=> 'resend-code'
]);

//Customer City Address Locator
Route::post('/update-city-address',[
   'uses'=>'ApiController@updateCityAddressLocation',
   'as'=> 'update-city-address'
]);

//Get Customer Information
Route::post('/get-customer-info',[
   'uses'=>'ApiController@getCustomerInformation',
   'as'=> 'get-customer-info'
]);

Route::post('/get-customer-info-primary-address',[
   'uses'=>'ApiController@getCustomerInformationWithPrimaryAddress',
   'as'=> 'get-customer-info-primary-address'
]);

//Customer Update Profile
Route::post('/update-customer-info',[
   'uses'=>'ApiController@doUpdateCustomerProfile',
   'as'=> 'update-customer-info'
]);


//Update Customer Address
Route::post('/update-customer-address',[
   'uses'=>'ApiController@doUpdateCustomerAddress',
   'as'=> 'update-customer-address'
]);

Route::post('/upload-photo',[
   'uses'=>'ApiController@doUploadPhoto',
   'as'=> 'upload-photo'
]);

// BOOK LIST =========================================================================
Route::post('/get-all-book-category-list',[
   'uses'=>'ApiController@getAllBookCategoryList',
   'as'=> 'get-all-book-category-list'
]);

Route::post('/get-all-book-list',[
   'uses'=>'ApiController@getAllBookList',
   'as'=> 'get-all-book-list'
]);

Route::post('/search-book-list',[
   'uses'=>'ApiController@searchBookList',
   'as'=> 'search-book-list'
]);

Route::post('/get-featured-list',[
   'uses'=>'ApiController@getFeaturedBookList',
   'as'=> 'get-featured-list'
]);

Route::post('/get-best-seller-list',[
   'uses'=>'ApiController@getBestSellerBookList',
   'as'=> 'get-best-seller-list'
]);

Route::post('/get-new-release-list',[
   'uses'=>'ApiController@getNewReleaseBookList',
   'as'=> 'get-new-release-list'
]);

Route::post('/get-free-book-list',[
   'uses'=>'ApiController@getFreeBookList',
   'as'=> 'get-free-book-list'
]);

Route::post('/get-premium-list',[
   'uses'=>'ApiController@getPremiumBookList',
   'as'=> 'get-premium-list'
]);


// CITY LIST =========================================================================
Route::post('/get-city-list',[
   'uses'=>'ApiController@getCityList',
   'as'=> 'get-city-list'
]);

// LIBRARY ==========================================================================
Route::post('/get-library-list',[
   'uses'=>'ApiController@getCustomerLibraryList',
   'as'=> 'get-library-list'
]);

Route::post('/add-to-favorites',[
   'uses'=>'ApiController@addToFavorites',
   'as'=> 'add-to-favorites'
]);


// FAVORITE ==========================================================================
Route::post('/get-favorite-list',[
   'uses'=>'ApiController@getCustomerFavoriteList',
   'as'=> 'get-favorite-list'
]);

Route::post('/add-to-favorites',[
   'uses'=>'ApiController@addToFavorites',
   'as'=> 'add-to-favorites'
]);

// CART ==============================================================================
Route::post('/get-cart-list',[
   'uses'=>'ApiController@getCustomerCartList',
   'as'=> 'get-cart-list'
]);

Route::post('/add-to-cart',[
   'uses'=>'ApiController@addToCart',
   'as'=> 'add-to-cart'
]);

Route::post('/remove-to-cart',[
   'uses'=>'ApiController@removeToCart',
   'as'=> 'remove-to-cart'
]);

// LIBRARY ==================================
Route::post('/get-customer-library-list',[
   'uses'=>'ApiController@getCustomerLibraryList',
   'as'=> 'get-customer-library-list'
]);

Route::post('/add-to-library',[
   'uses'=>'ApiController@addToLibrary',
   'as'=> 'add-to-library'
]);

// CART TRANS CHECK OUT =================================
Route::post('/proceed-to-checkout',[
   'uses'=>'ApiController@proceedToCheckOut',
   'as'=> 'proceed-to-checkout'
]);


// ORDER TRANSACTION ================================
Route::post('/get-order-history-list',[
   'uses'=>'ApiController@getCustomerOrderHistory',
   'as'=> 'get-order-history-list'
]);

Route::post('/get-order-information',[
   'uses'=>'ApiController@getCustomerOrderInformation',
   'as'=> 'get-order-information'
]);

Route::post('/get-order-details',[
   'uses'=>'ApiController@getCustomerOrderDetails',
   'as'=> 'get-order-details'
]);


// REVIEW & COMMENT===============================
Route::post('/get-review-list',[
   'uses'=>'ApiController@getBookReview',
   'as'=> 'get-review-list'
]);

Route::post('/post-comment-review',[
   'uses'=>'ApiController@doPostCommentReview',
   'as'=> 'post-comment-review'
]);

//BANNER ADS===============================
Route::post('/get-home-slider-banner',[
   'uses'=>'ApiController@getHomeSliderBanner',
   'as'=> 'get-home-slider-banner'
]);

Route::post('/get-home-popup-banner',[
   'uses'=>'ApiController@getPopUpBanner',
   'as'=> 'get-home-popup-banner'
]);

//COUPON ===============================
Route::post('/get-available-coupon-list',[
   'uses'=>'ApiController@getAvailableCouponList',
   'as'=> 'get-available-coupon-list'
]);

Route::post('/validate-coupon-code',[
   'uses'=>'ApiController@validateCouponCode',
   'as'=> 'validate-coupon-code'
]);

//SUBSCRIPTION PLAN ===============================
Route::post('/get-subscription-plan-list',[
   'uses'=>'ApiController@getSubscriptionPlanList',
   'as'=> 'get-subscription-plan-list'
]);

Route::post('/proceed-to-subscribe',[
   'uses'=>'ApiController@proceedToSubscribe',
   'as'=> 'proceed-to-subscribe'
]);

Route::post('/check-subscription-status',[
   'uses'=>'ApiController@checkSubscriptionStatus',
   'as'=> 'check-subscription-status'
]);


// CONTACT US FORM================================
Route::post('/send-inquiry',[
   'uses'=>'ApiController@doSendInquiry',
   'as'=> 'send-inquiry'
]);

// EWALLET CREDIT HISTORY================================
Route::post('/get-ewallet-history',[
   'uses'=>'ApiController@getEWalletCreditsHistory',
   'as'=> 'get-ewallet-history'
]);

// MESSAGE NOTIFICATION ================================
Route::post('/get-message-notification',[
   'uses'=>'ApiController@getMessageNotificationList',
   'as'=> 'get-message-notification'
]);


// EPUB VIEWER
Route::get('/show-viewer',[
   'uses'=>'ApiController@getShowViewerEpub',
   'as'=> 'show-viewer'
]);

