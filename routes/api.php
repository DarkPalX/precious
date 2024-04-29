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


 
// Route::get('/test-email',[
//   'uses'=>'App\Http\Controllers\ApiController@testEmailCall',
//   'as'=> 'test-email'
// ]);

// check and test api status
Route::get('/test', function(){
    return response([
            'message' => 'Api is working...'
     ], 200);

 });
 
// CUSTOMER CONTROLLER===========================================

//Customer Logout
Route::get('/logout',[
   'uses'=>'App\Http\Controllers\ApiController@doCheckLogin',
   'as'=> 'logout'
]);

//Customer Login
Route::post('/check-login',[
   'uses'=>'App\Http\Controllers\ApiController@doCheckLogin',
   'as'=> 'check-login'
]);

//Register New Customer Account
Route::post('/register-account',[
   'uses'=>'App\Http\Controllers\ApiController@doRegisterCustomer',
   'as'=> 'register-account'
]);

//Customer Forgot Password
Route::post('/forgot-password',[
   'uses'=>'App\Http\Controllers\ApiController@doForgotPassword',
   'as'=> 'forgot-password'
]);

//Customer Forgot Password
Route::post('/change-password',[
   'uses'=>'App\Http\Controllers\ApiController@doChangePassword',
   'as'=> 'change-password'
]);

//Customer Verify Account
Route::post('/verify-account',[
   'uses'=>'App\Http\Controllers\ApiController@doVerifyAccount',
   'as'=> 'verify-account'
]);

//Resend Verification Code
Route::post('/resend-code',[
   'uses'=>'App\Http\Controllers\ApiController@doResendVerificationCode',
   'as'=> 'resend-code'
]);

//Customer City Address Locator
Route::post('/update-city-address',[
   'uses'=>'App\Http\Controllers\ApiController@updateCityAddressLocation',
   'as'=> 'update-city-address'
]);

//Get Customer Information
Route::post('/get-customer-info',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerInformation',
   'as'=> 'get-customer-info'
]);

Route::post('/get-customer-info-primary-address',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerInformationWithPrimaryAddress',
   'as'=> 'get-customer-info-primary-address'
]);

//Customer Update Profile
Route::post('/update-customer-info',[
   'uses'=>'App\Http\Controllers\ApiController@doUpdateCustomerProfile',
   'as'=> 'update-customer-info'
]);


//Update Customer Address
Route::post('/update-customer-address',[
   'uses'=>'App\Http\Controllers\ApiController@doUpdateCustomerAddress',
   'as'=> 'update-customer-address'
]);

Route::post('/upload-photo',[
   'uses'=>'App\Http\Controllers\ApiController@doUploadPhoto',
   'as'=> 'upload-photo'
]);

// BOOK LIST =========================================================================
Route::post('/get-all-book-category-list',[
   'uses'=>'App\Http\Controllers\ApiController@getAllBookCategoryList',
   'as'=> 'get-all-book-category-list'
]);

Route::post('/get-all-book-list',[
   'uses'=>'App\Http\Controllers\ApiController@getAllBookList',
   'as'=> 'get-all-book-list'
]);

Route::post('/search-book-list',[
   'uses'=>'App\Http\Controllers\ApiController@searchBookList',
   'as'=> 'search-book-list'
]);

Route::post('/get-featured-list',[
   'uses'=>'App\Http\Controllers\ApiController@getFeaturedBookList',
   'as'=> 'get-featured-list'
]);

Route::post('/get-best-seller-list',[
   'uses'=>'App\Http\Controllers\ApiController@getBestSellerBookList',
   'as'=> 'get-best-seller-list'
]);

Route::post('/get-new-release-list',[
   'uses'=>'App\Http\Controllers\ApiController@getNewReleaseBookList',
   'as'=> 'get-new-release-list'
]);

Route::post('/get-free-book-list',[
   'uses'=>'App\Http\Controllers\ApiController@getFreeBookList',
   'as'=> 'get-free-book-list'
]);

Route::post('/get-premium-list',[
   'uses'=>'App\Http\Controllers\ApiController@getPremiumBookList',
   'as'=> 'get-premium-list'
]);


// CITY LIST =========================================================================
Route::post('/get-city-list',[
   'uses'=>'App\Http\Controllers\ApiController@getCityList',
   'as'=> 'get-city-list'
]);

// LIBRARY ==========================================================================
Route::post('/get-library-list',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerLibraryList',
   'as'=> 'get-library-list'
]);

Route::post('/add-to-favorites',[
   'uses'=>'App\Http\Controllers\ApiController@addToFavorites',
   'as'=> 'add-to-favorites'
]);


// FAVORITE ==========================================================================
Route::post('/get-favorite-list',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerFavoriteList',
   'as'=> 'get-favorite-list'
]);

Route::post('/add-to-favorites',[
   'uses'=>'App\Http\Controllers\ApiController@addToFavorites',
   'as'=> 'add-to-favorites'
]);

// CART ==============================================================================
Route::post('/get-cart-list',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerCartList',
   'as'=> 'get-cart-list'
]);

Route::post('/add-to-cart',[
   'uses'=>'App\Http\Controllers\ApiController@addToCart',
   'as'=> 'add-to-cart'
]);

Route::post('/remove-to-cart',[
   'uses'=>'App\Http\Controllers\ApiController@removeToCart',
   'as'=> 'remove-to-cart'
]);

// LIBRARY ==================================
Route::post('/get-customer-library-list',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerLibraryList',
   'as'=> 'get-customer-library-list'
]);

Route::post('/add-to-library',[
   'uses'=>'App\Http\Controllers\ApiController@addToLibrary',
   'as'=> 'add-to-library'
]);

//SUBSCRIBED OPEN READ BOOKS
Route::post('/get-subscribed-read-books-list',[
   'uses'=>'App\Http\Controllers\ApiController@getSubscribedReadBooksList',
   'as'=> 'get-subscribed-read-books-list'
]);

Route::post('/save-read-books',[
   'uses'=>'App\Http\Controllers\ApiController@saveReadSubscribedBooks',
   'as'=> 'save-read-books'
]);

// CART TRANS CHECK OUT =================================
Route::post('/proceed-to-checkout',[
   'uses'=>'App\Http\Controllers\ApiController@proceedToCheckOut',
   'as'=> 'proceed-to-checkout'
]);

// ORDER TRANSACTION ================================
Route::post('/get-order-history-list',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerOrderHistory',
   'as'=> 'get-order-history-list'
]);

Route::post('/get-order-information',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerOrderInformation',
   'as'=> 'get-order-information'
]);

Route::post('/get-order-details',[
   'uses'=>'App\Http\Controllers\ApiController@getCustomerOrderDetails',
   'as'=> 'get-order-details'
]);


// REVIEW & COMMENT===============================
Route::post('/get-review-list',[
   'uses'=>'App\Http\Controllers\ApiController@getBookReview',
   'as'=> 'get-review-list'
]);

Route::post('/post-comment-review',[
   'uses'=>'App\Http\Controllers\ApiController@doPostCommentReview',
   'as'=> 'post-comment-review'
]);

//BANNER ADS===============================
Route::post('/get-home-slider-banner',[
   'uses'=>'App\Http\Controllers\ApiController@getHomeSliderBanner',
   'as'=> 'get-home-slider-banner'
]);

Route::post('/get-home-popup-banner',[
   'uses'=>'App\Http\Controllers\ApiController@getPopUpBanner',
   'as'=> 'get-home-popup-banner'
]);

//COUPON ===============================
Route::post('/get-available-coupon-list',[
   'uses'=>'App\Http\Controllers\ApiController@getAvailableCouponList',
   'as'=> 'get-available-coupon-list'
]);

Route::post('/validate-coupon-code',[
   'uses'=>'App\Http\Controllers\ApiController@validateCouponCode',
   'as'=> 'validate-coupon-code'
]);

//SUBSCRIPTION PLAN ===============================
Route::post('/get-subscription-plan-list',[
   'uses'=>'App\Http\Controllers\ApiController@getSubscriptionPlanList',
   'as'=> 'get-subscription-plan-list'
]);

Route::post('/proceed-to-subscribe',[
   'uses'=>'App\Http\Controllers\ApiController@proceedToSubscribe',
   'as'=> 'proceed-to-subscribe'
]);

Route::post('/check-subscription-status',[
   'uses'=>'App\Http\Controllers\ApiController@checkSubscriptionStatus',
   'as'=> 'check-subscription-status'
]);

Route::post('/cancel-subscription-plan',[
   'uses'=>'App\Http\Controllers\ApiController@cancelSubscriptionPlan',
   'as'=> 'cancel-subscription-plan'
]);

// CONTACT US FORM================================
Route::post('/send-inquiry',[
   'uses'=>'App\Http\Controllers\ApiController@doSendInquiry',
   'as'=> 'send-inquiry'
]);

// EWALLET CREDIT HISTORY================================
Route::post('/get-ewallet-history',[
   'uses'=>'App\Http\Controllers\ApiController@getEWalletCreditsHistory',
   'as'=> 'get-ewallet-history'
]);

// MESSAGE NOTIFICATION ================================
Route::post('/get-message-notification',[
   'uses'=>'App\Http\Controllers\ApiController@getMessageNotificationList',
   'as'=> 'get-message-notification'
]);

Route::post('/open-message-notification',[
   'uses'=>'App\Http\Controllers\ApiController@openSetReadMessageNotification',
   'as'=> 'open-message-notification'
]);

Route::post('/delete-message-notification',[
   'uses'=>'App\Http\Controllers\ApiController@deleteReadMessageNotification',
   'as'=> 'delete-message-notification'
]);

// EPUB VIEWER
Route::get('/show-viewer',[
   'uses'=>'App\Http\Controllers\ApiController@showViewerEpub',
   'as'=> 'show-viewer'
]);


