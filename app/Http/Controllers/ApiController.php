<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

use Mail;
use Session;
use Hash;
use View;
use Image;
use DB;
use Excel;
use PDF;

use App\Models\Misc;
use App\Models\Book;
use App\Models\City;
use App\Models\Cart;
use App\Models\Order;
use App\Models\EWallet;
use App\Models\Review;
use App\Models\Contact;
use App\Models\Library;
use App\Models\Voucher;
use App\Models\Messages;
use App\Models\BannerAds;
use App\Models\Favorites;
use App\Models\Subscription;
use App\Models\UserCustomer;

class ApiController extends Controller {

// CUSTOMER=======================================
  public function doLogout(){
     return response()->json($RetVal);
  }

// CUSTOMER LOGIN==================================
  public function doCheckLogin(Request $request){
   
    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');

    $data['EmailAddress'] =  $request->post('EmailAddress');
    $data['Password'] =  $request->post('Password');

     if(empty($data['EmailAddress'])){
      $ResponseMessage = 'Email address is required.';
      return response()->json([
          'response' => 'Failed',
          'message' => $ResponseMessage,
      ]);
    }

    if(empty($data['Password'])){
      $ResponseMessage ='Password is required.';
      return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if($Misc->IsValidEmail($data['EmailAddress'])==false){
      $ResponseMessage ='Enter your valid email address.';
      return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

     $getPassword=''; 
     $chkIsActive=0;
     $info=$UserCustomer->getUserLoginPassword($data['EmailAddress']);
     
     if(isset($info)>0){         
         $getPassword= $info->password;
         $chkIsActive= $info->is_active;
         //check bycrypt
         if (Hash::check($data['Password'], $getPassword)){
                if($chkIsActive==1){
                    return response()->json([
                      'data' => $info,
                      'response' => 'Success',
                      'message' => "Naa tama ang password..",
                     ]);  
                }else{

                    return response()->json([
                      'data' => null,
                      'response' => 'Failed',
                      'message' => "Your account is in-acative. To activate, just email our admin & staff. ",                      
                   ]); 
                }
              
             
         }else{
            return response()->json([
                    'data' => null,
                    'response' => 'Failed',
                    'message' => "Invalid login credentials.",
                 ]); 
         }
     }else{
          return response()->json([
                'data' => null,
                'response' => 'Failed',
                // 'message' => "Your account is in-acative. To activate, just email our admin & staff. ",
                'message' => "Invalid login credentials.",
             ]); 
     }
     
  }
 
  // REGISTER NEW CUSTOMER======================================
  public function doRegisterCustomer(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');    
    
    $data['UserID']=0;
    $data['FirstName'] = $request->post('FirstName');
    $data['LastName'] = $request->post('LastName');
    $data['FullName'] =  $data['FirstName'] .' '. $data['LastName']; 
    
    $data['UserName'] = '';
    $data['EmailAddress'] = $request->post('EmailAddress');
    $data['MobileNo'] = $request->post('MobileNo');

    $data['Password'] = $request->post('Password');
    $data['RepeatPassword'] = $request->post('RepeatPassword');
    
    if(empty($data['FirstName'])){
      $ResponseMessage = 'First name is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    if(empty($data['LastName'])){
      $ResponseMessage = 'Last name name is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }
    
    if(empty($data['EmailAddress'])){
      $ResponseMessage ='Email address is required.';    
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['MobileNo'])){
      $ResponseMessage ='Mobile number is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['Password'])){
      $ResponseMessage ='Password is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['RepeatPassword'])){
      $ResponseMessage ='Confirm password is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if($Misc->IsValidEmail($data['EmailAddress'])==false){
      $ResponseMessage ='Enter current & valid email address.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(!empty($data['Password']) &&  strlen($data['Password'])<6){
      $ResponseMessage ='Password must be atleast 6 character or more.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(!empty($data['RepeatPassword']) &&  strlen($data['RepeatPassword'])<6){
      $ResponseMessage ='Confirm password must be atleast 6 character or more.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if($data['Password']!=$data['RepeatPassword']){
      $ResponseMessage ='Password & Confirm password does not matched.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
     

    if(!empty($data['EmailAddress']) && $Misc->isDataExist('users', 'id', $data['UserID'], "email", $data['EmailAddress'])){
        $ResponseMessage = 'Email address is already registered. Login your account or use forgot password.';
         return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(!empty($data['MobileNo']) && $Misc->isDataExist('users', 'id', $data['UserID'], "mobile", $data['MobileNo'])){
        $ResponseMessage = 'Mobile number is already registered.';
         return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }          
  
    //SUCCESS SAVE USER 
    $retVal=$UserCustomer->doRegisterCustomer($data);
     return response()->json([
      'response' => 'Success',
      'message' => "You have successfully registered. Login to your account now.",
    ]);                     
           
  }

  //CUSTOMER FORGOT PASSWORD=================================  
  public function doForgotPassword(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['EmailAddress'] = $request->post('EmailAddress');

    if(empty($data['EmailAddress'])){
      $ResponseMessage ='Email address is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if($Misc->IsValidEmail($data['EmailAddress'])==false){
      $ResponseMessage ='Enter your valid email address.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
        
    $CustomerID=0;
    $response=$UserCustomer->doForgotPassword($data);
    if($response=='Success'){      
        return response()->json([                  
         'response' => $response,
         'message' => "Your new & temporary password has sent to your email.",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'message' => "Email address does not exist.",
       ]); 
    } 
  }

    //CUSTOMER CHANGE PASSWORD=================================  
  public function doChangePassword(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');

    // $data['UserID'] = 51;
    $data['OldPassword'] = $request->post('OldPassword');
    $data['NewPassword'] = $request->post('NewPassword');
    $data['ConfirmNewPassword'] = $request->post('ConfirmNewPassword');

    if(empty($data['OldPassword'])){
      $ResponseMessage ='Old password is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(!empty($data['NewPassword']) &&  strlen($data['NewPassword'])<6){
      $ResponseMessage ='Password must be atleast 6 character or more.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(!empty($data['ConfirmNewPassword']) &&  strlen($data['ConfirmNewPassword'])<6){
      $ResponseMessage ='Confirm password must be atleast 6 character or more.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if($data['NewPassword']!=$data['ConfirmNewPassword']){
      $ResponseMessage ='Password & Confirm password does not matched.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
    

    //Checking of password
    $getEmailAddress=''; 
    $info=$UserCustomer->getCustomerInformation($data);
    if(isset($info)>0){

      $getEmailAddress= $info->emailaddress;     

       $getPassword='';                
       $info=$UserCustomer->getUserLoginPassword($getEmailAddress);

      if(isset($info)>0){                               
         $getPassword= $info->password;
         //check bycrypt

         if (Hash::check($data['OldPassword'], $getPassword)){

            $response=$UserCustomer->doUserChangePassword($data);            
               if($response=='Success'){      
                return response()->json([                  
                'response' => $response,
                'message' => "You have successfully changed your password.",
                 ]);    
              }                
         }else{
            return response()->json([
                    'data' => null,
                    'response' => 'Failed',
                    'message' => "Invalid old password.",
                 ]); 
         }
     }else{
          return response()->json([
                'data' => null,
                'response' => 'Failed',
                'message' => "Invalid old password.",
             ]); 
     }

   }else{
      return response()->json([
          'data' => null,
          'response' => 'Failed',
          'message' => "Invalid old password.",
      ]);    
   }
 }

 //CUSTOMER VERIFY ACCOUNT=================================  
  public function doVerifyAccount(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');
    $data['VerficationCode'] = $request->post('VerficationCode');    

    if(empty($data['VerficationCode'])){
      $ResponseMessage ='Enter your 4 digit verification code.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(!empty($data['VerficationCode']) &&  strlen($data['VerficationCode'])<4){
      $ResponseMessage ='Enter your 4 digit verification code.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
            
    $response=$UserCustomer->doVerifyAccount($data);
    if($response=='Success'){      
        return response()->json([                  
         'response' => $response,
         'message' => "You have successfully verified your account.",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'message' => "Invalid verification code.",
       ]); 
    } 
  }

  //RESEND VERIFICATION CODE=================================  
  public function doResendVerificationCode(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();
    
    $VerficationCode='';
    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');  

    $data['UserID'] = $request->post('UserID');
    $data['EmailAddress'] = $request->post('EmailAddress');

    $response=$UserCustomer->doResendVerificationCode($data); 
    
    if($response=='Success'){      
      $VerficationCode=$UserCustomer->getVerificationCodeByID($data);
        return response()->json([                  
         'response' => $response,
         'code' => $VerficationCode,
         'message' => "New verfication code will be send to your email in a while.",
       ]);    

    }else{
        return response()->json([
          'response' =>$response,
          'code' => '',
          'message' => "Something went wrong while sending new verification code.",
       ]); 
    } 
  }

 //CUSTOMER UPDATE CITY ADDRESS LOCATION=================================  
  public function updateCityAddressLocation(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');
    $data['CityName'] = $request->post('CityName');    

    if(empty($data['CityName'])){
      $ResponseMessage ='Select city from the list.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
            
    $response=$UserCustomer->updateCityAddressLocation($data);
    if($response=='Success'){      
        return response()->json([                  
         'response' => 'Success',
         'message' => "You have successfully set your city location.",
       ]);    

    }else{
        return response()->json([
          'response' =>'Failed',
          'message' => "Something went wrong while setting city location.",
       ]); 
    } 
  }

 //CUSTOMER PASSWORD RESET=================================  
  public function doPasswordReset(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['EmailAddress'] = $request->post('EmailAddress');
    $data['CurrentPassword'] = $request->post('CurrentPassword');
    $data['NewPassword'] = $request->post('NewPassword');

    if(empty($data['EmailAddress'])){
      $ResponseMessage ='Email address is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['CurrentPassword'])){
      $ResponseMessage ='Current password is required.';    
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['NewPassword'])){
      $ResponseMessage ='New password is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if($Misc->IsValidEmail($data['EmailAddress'])==false){
      $ResponseMessage ='Enter your valid email address.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
        
    $CustomerID=0;
    $Info=$UserCustomer->doPasswordReset($data);
    if($Info>0){
        return response()->json([
         'data' => $Info,
         'response' => 'Success',
         'message' => "User is successfully logged-in.",
       ]);    

    }else{
        return response()->json([
          'data' => null,
          'response' => 'Failed',
          'message' => "Invalid login credentials.",
       ]); 
    } 

  }

 // GET CUSTOMER INFORMATION========================================================================
 public function getCustomerInformation(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['UserID'] = $request->post('UserID');
                
    $Info=$UserCustomer->getCustomerInformation($data);

    if(isset($Info)>0){      
        return response()->json([                  
         'response' => 'Success',
         'data' => $Info,
         'message' => "Customer with ID ". $data['UserID']. " has profile data.",
       ]);    

    }else{
        return response()->json([
          'response' => 'Failed',
          'data' => null,
          'message' => "Customer does not exist.",
       ]); 
    } 
  }

   // GET CUSTOMER INFORMATION WITH PRIMARY ADDRESS========================================================================
 public function getCustomerInformationWithPrimaryAddress(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['CustomerID'] = $request->post('UserID');
                
    $Info=$UserCustomer->getCustomerInformation($data);
    if(isset($Info)>0){      
        return response()->json([                  
         'response' => 'Success',
         'data' => $Info,
         'message' => "Customer with ID ". $data['CustomerID']. " has profile data.",
       ]);    

    }else{
        return response()->json([
          'response' => 'Failed',
          'data' => '',
          'message' => "Customer does not exist.",
       ]); 
    } 
  }

  // UPDATE CUSTOMER PROFILE======================================
  public function doUpdateCustomerProfile(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');    
    
    $data['UserID']=$request->post('UserID');

    $data['FirstName'] = $request->post('FirstName'); 
    $data['LastName'] = $request->post('LastName'); 
       
    $data['MobileNo'] = $request->post('MobileNo');
    $data['EmailAddress'] = $request->post('EmailAddress');

    $data['BirthDate'] = $request->post('BirthDate');
    $data['FullName'] =  $data['FirstName'] .' '. $data['LastName'];   

    $data['StreetAddress'] = $request->post('StreetAddress'); 
    $data['CityName'] = $request->post('CityName');      
    $data['ZipCode'] = $request->post('ZipCode'); 
    

    if(empty($data['FirstName'])){
      $ResponseMessage = 'First name is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    if(empty($data['LastName'])){
      $ResponseMessage = 'Last name name is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }
    
    if(empty($data['EmailAddress'])){
      $ResponseMessage ='Email address is required.';    
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['BirthDate'])){
      $ResponseMessage ='Birth date is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['FirstName'])){
      $ResponseMessage = 'First name is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }


    if($Misc->IsValidEmail($data['EmailAddress'])==false){
      $ResponseMessage ='Enter current & valid email address.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }


    if(empty($data['StreetAddress'])){
      $ResponseMessage = 'Street address is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    if(empty($data['CityName'])){
      $ResponseMessage = 'Select city from the list';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }
    
    if(empty($data['ZipCode'])){
      $ResponseMessage ='Zipcode is required.';    
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    // if(!empty($data['EmailAddress']) && $Misc->isDataExist('customer', 'UserAccountID', $data['UserCustomerID'], "EmailAddress", $data['EmailAddress'])){
    //     $ResponseMessage = 'Email address is already used.';
    //      return response()->json([
    //      'response' => 'Failed',
    //      'message' => $ResponseMessage,
    //     ]);
    // }

    // if(!empty($data['MobileNo']) && $Misc->isDataExist('customer', 'UserAccountID', $data['UserCustomerID'], "MobileNo", $data['MobileNo'])){
    //     $ResponseMessage = 'Mobile number is already used.';
    //      return response()->json([
    //      'response' => 'Failed',
    //      'message' => $ResponseMessage,
    //     ]);
    // }

    //SUCCESS SAVE USER 
    $retVal=$UserCustomer->doUpdateCustomerProfile($data);
     return response()->json([
      'response' => 'Success',
      'message' => "You have successfully updated your profile.",
    ]);                     
           
  }

// GET CUSTOMER ADDRESS====================================================
// public function getCustomerAddressInformation(Request $request){

//     $Misc = new Misc();
//     $UserCustomer = new UserCustomer();

//     $response = "Failed";
//     $responseMessage = "";

//     $data['Platform'] = config('app.PLATFORM_ANDROID');   
//     $data['CustomerID'] = $request->post('UserID');
                
//     $Info=$UserCustomer->getCustomerAddressInformation($data);
//     if(isset($Info)>0){      
//         return response()->json([                  
//          'response' => 'Success',
//          'data' => $Info,
//          'message' => "Customer with ID ". $data['CustomerID']. " has address data.",
//        ]);    

//     }else{
//         return response()->json([
//           'response' => 'Failed',
//           'data' => '',
//           'message' => "Customer does not exist.",
//        ]); 
//     } 
//  }

// UPDATE CUSTOMER ADDRESS======================================
  public function doUpdateCustomerAddress(Request $request){

    $Misc = new Misc();
    $UserCustomer = new UserCustomer();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');    
    
    $data['UserID']=$request->post('UserID');
    
    $data['StreetAddress'] = $request->post('StreetAddress'); 
    $data['CityName'] = $request->post('CityName');      
    $data['ZipCode'] = $request->post('ZipCode');
  
    if(empty($data['StreetAddress'])){
      $ResponseMessage = 'Street address is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    if(empty($data['CityName'])){
      $ResponseMessage = 'Select city from';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }
    
    if(empty($data['ZipCode'])){
      $ResponseMessage ='Zipcode is required.';    
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    //SUCCESS SAVE USER 
    $retVal=$UserCustomer->doUpdateCustomerAddress($data);
     return response()->json([
      'response' => 'Success',
      'message' => "You have successfully updated your address.",
    ]);                     
           
  }

  function doUploadPhoto(Request $request){

     $data['image']=$request->post('image');
     $data['filename']=$request->post('filename');

      return response()->json([
      'response' => 'Success',
      'message' => $data['filename'],
    ]); 

  }

  //LIBRARY=====================================================================
public function getCustomerLibraryList(Request $request){
    
    $Misc = new Misc();
    $Library = new Library();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['UserID']=$request->post('UserID');

    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$Library->getLibraryList($data);  
    return response()->json($result); 
    
}

//FAVORITES=====================================================================
public function getCustomerFavoriteList(Request $request){
    
    $Misc = new Misc();
    $Favorites = new Favorites();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');       
    $data['UserID']=$request->post('UserID');

    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$Favorites->getFavoriteList($data);  
    return response()->json($result); 
    
}

public function addToFavorites(Request $request){

    $Misc = new Misc();
    $Favorites = new Favorites();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');
    $data['ProductID'] = $request->post('ProductID');

    if($data['ProductID']<=0){
      $ResponseMessage ='Select a book to add into your favorites.';
       return response()->json([
         'response' => 'Failed',         
         'message' => $ResponseMessage,
        ]);
    }
    
    if($Favorites->checkProductsIfExist($data['ProductID'],$data['UserID'])){
       $ResponseMessage ='Book is already in your wishlist.';
       return response()->json([
         'response' => 'Failed',         
         'message' => $ResponseMessage,
        ]); 
        
    }

    $response=$Favorites->addToFavorites($data);
    if($response=='Success'){      
        return response()->json([                  
         'response' => $response,
         'message' => "Book has successfully added to your wishlist",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'message' => "Something wrong while adding book to your wishlist.",
       ]); 
    } 

}

//CART ITEM LIST===========================================================================
public function getCustomerCartList(Request $request){
    
    $Misc = new Misc();
    $Cart = new Cart();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    
    $data['UserID']=$request->post('UserID');

    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$Cart->getCartList($data);  
    return response()->json($result); 
    
}

// ADD TO CART===============================================================
public function addToCart(Request $request){

    $Misc = new Misc();
    $Cart = new Cart();
    $Library = new Library();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');
    $data['ProductID'] = $request->post('ProductID');
    $data['ProductQty'] = $request->post('ProductQty');
    $data['ProductPrice'] = $request->post('ProductPrice');
    $data['ProductDiscount'] = $request->post('ProductDiscount');

    if($data['ProductID']<=0){
      $ResponseMessage ='Select a book to add into your cart.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
    
    if($Cart->checkProductsIfExist($data['ProductID'],$data['UserID'])){
       $ResponseMessage ='Book is already in your cart.';
       return response()->json([
         'response' => 'Failed',         
         'message' => $ResponseMessage,
        ]); 
        
    }

    if($Library->checkProductsIfExistInLibrary($data['ProductID'],$data['UserID'])){
       $ResponseMessage ='You already have purchased this book.';
       return response()->json([
         'response' => 'Failed',         
         'message' => $ResponseMessage,
        ]); 
        
    }
     
    $total_item_cart=0;
    $response=$Cart->addToCart($data);
    if($response=='Success'){      
 
        $total_item_cart=$Cart->getCustomerCartItemCount($data['UserID']);
        
        return response()->json([                  
         'response' => $response,
         'total' => $total_item_cart,
         'message' => "Book has successfully added to your cart",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'total' => 0,
          'message' => "Something wrong while adding book to your cart.",
       ]); 
    } 

}

// REMOVE TO CART==========================================================
public function removeToCart(Request $request){

    $Misc = new Misc();
    $Cart = new Cart();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');
    $data['ProductID'] = $request->post('ProductID');
    
    if($data['ProductID']<=0){
      $ResponseMessage ='Select a book to remove from your cart.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
    
    $response=$Cart->removeToCart($data);
    if($response=='Success'){      
      $total_item_cart=$Cart->getCustomerCartItemCount($data['UserID']);
        return response()->json([                  
         'response' => $response,
         'total' => $total_item_cart,
         'message' => "Book has successfully removed to your cart",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'total' => 0,
          'message' => "Something wrong while removing book to your cart.",
       ]); 
    } 

}

// PROCEED TO CHECK OUT==========================================================
public function proceedToCheckOut(Request $request){
    
    $Cart = new Cart();
    $Order = new Order();
    $Voucher = new Voucher();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');    
    $data['ApplyECredit'] = $request->post('ApplyECredit');
    $data['PaymentMethod'] = $request->post('PaymentMethod');
    $data['SubTotal'] = $request->post('SubTotal');
    $data['AmountPaid'] = $request->post('AmountPaid');

    $data['VoucherCode'] = $request->post('VoucherCode');
    $data['VoucherDiscountAmount'] = $request->post('VoucherAmount');
     
    $response=$Order->proceedToCheckOut($data);
    if($response=='Success'){      
        return response()->json([                  
         'response' => $response,
         'message' => "You have successfully purchase your favorite books.",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'message' => "Something wrong while checking out order.",
       ]); 
    } 

}

//BOOK LIST==================================================================
public function getAllBookCategoryList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['Status'] = 'All';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $result=$Books->getAllBookCatergoryList($data);  

  return response()->json($result); 
  }

 public function getAllBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['Status'] = 'All';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $result=$Books->getBookList($data);  

  return response()->json($result); 
  }

 public function searchBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 

  $data['Status'] = "All";
  $data['SearchText'] = $request->post('SearchText');

  $data['Filter_Sort'] = $request->post('Filter_Sort');
  $data['Filter_Genre'] = $request->post('Filter_Genre');
  $data['Filter_Star'] = $request->post('Filter_Star');

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $result=$Books->getSearchBookList($data);  

  return response()->json($result); 
  }

  public function getFeaturedBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['SearchText'] = '';
  $data['Status'] = 'Featured';
  

  $data["PageNo"] = 0;
  $data["Limit"] = 15;

  $result=$Books->getBookList($data);  

  return response()->json($result); 
  }

  public function getBestSellerBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['SearchText'] = '';
  $data['Status'] = 'Best Seller';
  

  $data["PageNo"] = 0;
  $data["Limit"] = 15;

  $result=$Books->getBookList($data);  

  return response()->json($result); 
  }

  public function getNewReleaseBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['SearchText'] = '';
  $data['Status'] = 'New Release';
  

  $data["PageNo"] = 0;
  $data["Limit"] = 15;

  $result=$Books->getBookList($data);  

  return response()->json($result); 
  }

    public function getPremiumBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['SearchText'] = '';
  $data['Status'] = 'Premium';
  

  $data["PageNo"] = 0;
  $data["Limit"] = 15;

  $result=$Books->getBookList($data);  

  return response()->json($result); 
  }

  public function getFreeBookList(Request $request){

  $Books = new Book();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['SearchText'] = '';
  $data['Status'] = 'Free';
  

  $data["PageNo"] = 0;
  $data["Limit"] = 15;

  $result=$Books->getBookList($data);  

  return response()->json($result); 
  }

//ORDER TRANSACTION===============================================================

  public function getCustomerOrderHistory(Request $request){

  $Order = new Order();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['UserID'] = $request->post('UserID');

  $data['Status'] = '';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $result=$Order->getOrderList($data);  

  return response()->json($result); 
  }

  public function getCustomerOrderInformation(Request $request){

  $Order = new Order();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['OrderID'] = $request->post('OrderID');

  $data['Status'] = '';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $sales_header=$Order->getOrderInfo($data['OrderID']);  
  if(isset($sales_header)>0){

     $response='Success';     
      if($response=='Success'){        
        return response()->json([                  
         'response' => $response,
         'data' => $sales_header,         
         'message' => "Customer has order header & detail transaction info.",
       ]);    

    }else{

        return response()->json([
          'response' => $response,
          'data' => null,         
          'message' => "Something wrong while getting customer order information",
       ]); 
    } 

  }else{
      return response()->json([
          'response' => $response,
          'data' => null,         
          'message' => "Something wrong while getting customer order information",
       ]);
    }
}

 public function getCustomerOrderDetails(Request $request){

  $Order = new Order();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['OrderID'] = $request->post('OrderID');

  $data['Status'] = '';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $sales_details=$Order->getOrderItemList($data['OrderID']);  
  if(isset($sales_details)>0){     
    return response()->json($sales_details); 
  }
}

// CONTACT US FORM========================================================= 
 public function doSendInquiry(Request $request){

    $Misc = new Misc();
    $Contact = new Contact();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');    
        
    $data['Purpose'] = $request->post('Purpose');
    $data['UserID'] = $request->post('UserID');
    $data['FullName'] = $request->post('FullName');
    $data['EmailAddress'] = $request->post('EmailAddress');      
    $data['MobileNo'] = $request->post('MobileNo');
    $data['Message'] = $request->post('Message');
    
    if(empty($data['Purpose'])){
      $ResponseMessage = 'Select inquiry type from the list.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    if(empty($data['FullName'])){
      $ResponseMessage = 'Full name is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    if(empty($data['EmailAddress'])){
      $ResponseMessage ='Email address is required.';    
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    if(empty($data['MobileNo'])){
      $ResponseMessage ='Mobile number is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }
    
     if(empty($data['Message'])){
      $ResponseMessage ='Message inquiry is required.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }


    if($Misc->IsValidEmail($data['EmailAddress'])==false){
      $ResponseMessage ='Enter current & valid email address.';
       return response()->json([
         'response' => 'Failed',
         'message' => $ResponseMessage,
        ]);
    }

    //SUCCESS SAVE CONTACT 
    $retVal=$Contact->doSendInquiry($data);
     return response()->json([
      'response' => 'Success',
      'message' => "Your inquiry has successfully send. Wait for admin to contact you.",
    ]);                     
           
  }

//COMMENTS & REVIEW=====================================================================
public function getBookReview(Request $request){
    
    $Misc = new Misc();
    $Review = new Review();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['ProductID']=$request->post('ProductID');

    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$Review->getReviewList($data);  
    return response()->json($result); 
    
}

public function doPostCommentReview(Request $request){

    $Misc = new Misc();
    $Review = new Review();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');    
        
    $data['UserID'] = $request->post('UserID');
    $data['ProductID'] = $request->post('ProductID');

    $data['Comment'] = $request->post('Comment');
    $data['Rating'] = $request->post('Rating');

    if(empty($data['Comment'])){
      $ResponseMessage = 'Post comment is required.';
       return response()->json([
           'response' => 'Failed',
           'message' => $ResponseMessage,
       ]);
    }

    //SUCCESS SAVE CONTACT 
    $retVal=$Review->doPostComment($data);
     return response()->json([
      'response' => 'Success',
      'message' => "Your comment has successfully send & subject for Admins approval.",
    ]);                     
           
  }

//BANNER ADS=====================================================================
public function getHomeSliderBanner(Request $request){
    
    $Misc = new Misc();
    $BannerAds = new BannerAds();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['Type']=$request->post('Type');

    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$BannerAds->getHomeSliderBanner($data);  
    return response()->json($result); 
    
}

public function getPopUpBanner(Request $request){
    
    $Misc = new Misc();
    $BannerAds = new BannerAds();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['Type']=$request->post('Type');

    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$BannerAds->getRandomPopUpBanner($data);  
    return response()->json($result); 
    
}


//SUBSCRIPTION PLAN=====================================================================
public function getSubscriptionPlanList(Request $request){
    
    $Misc = new Misc();
    $Subscription = new Subscription();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    
    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$Subscription->getSubscriptionPlanList($data);  
    return response()->json($result); 
    
}

// PROCEED TO CHECK OUT==========================================================
public function proceedToSubscribe(Request $request){
    
    $Cart = new Cart();
    $Subscription = new Subscription();
    

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   

    $data['UserID'] = $request->post('UserID');    
    $data['SubscriptionPlanID'] = $request->post('PlanID');
    $data['ApplyECredit'] = $request->post('ApplyECredit');
    $data['PaymentMethod'] = $request->post('PaymentMethod');
    $data['SubTotal'] = $request->post('SubTotal');
     
    $response=$Subscription->proceedToSubscribe($data);
    if($response=='Success'){      
        return response()->json([                  
         'response' => $response,
         'message' => "You have successfully subscribe to plan.",
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'message' => "Something wrong while subscribing to plan.",
       ]); 
    } 

}

// PROCEED TO CHECK OUT==========================================================
public function checkSubscriptionStatus(Request $request){
    
    $Cart = new Cart();
    $UserCustomer = new UserCustomer();
    $Subscription = new Subscription();
    
    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['UserID'] = $request->post('UserID');    
     
    $response=$Subscription->checkSubscriptionStatus($data);
    if($response=='Success'){   
        $Info=$UserCustomer->getCustomerInformation($data);
        return response()->json([                  
         'response' => $response,
         'data' => $Info,
         'message' => "You have successfully check customer subscription plan."
       ]);    

    }else{
        return response()->json([
          'response' => $response,
          'data' => null,
          'message' => "Something wrong while checking subscription plan.",
       ]); 
    } 

}

//COUPON CODE=====================================================================
public function getAvailableCouponList(Request $request){
    
    $Misc = new Misc();
    $Voucher = new Voucher();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    
    $data["SearchText"] = '';
    $data["Status"] = '';
    $data["PageNo"] = 0;
    $data["Limit"] = 0;

    $result=$Voucher->getVoucherList($data);  
    return response()->json($result); 
    
}

//VALIDATE COUPON CODE=====================================================================
public function validateCouponCode(Request $request){
    
    $Misc = new Misc();
    $Voucher = new Voucher();

    $response = "Failed";
    $responseMessage = "";

    $data['Platform'] = config('app.PLATFORM_ANDROID');   
    $data['VoucherCode']=$request->post('VoucherCode');

    if($data['VoucherCode']!=''){       

      $getVoucherPercentDiscount=0;
      $getVoucherAmountDiscount=0;
      $getRequiredQty=0;
      $getMinPurchase=0;
      $getScopeCustomerEmail=0;
      $voucher_info=$Voucher->getVoucherInfoByCode($data['VoucherCode']);

      if(isset($voucher_info)>0){

          $getVoucherPercentDiscount=$voucher_info->percentage;
          $getVoucherAmountDiscount=$voucher_info->discount_amount;
          $getRequiredQty=$voucher_info->purchase_qty;
          $getMinPurchase=$voucher_info->min_purchsae_amount;

          // $getScopeCustomerEmail=$voucher_info->scope_customer_id;
                  
           return response()->json([
             'response' => 'Success',         
             'percent_discount' => $getVoucherPercentDiscount,         
             'amount_discount' => $getVoucherAmountDiscount,   
             'required_qty' => $getRequiredQty, 
             'min_purchase' => $getMinPurchase, 
             'message' => 'Voucher Discount is '.$getVoucherPercentDiscount. '%',
            ]); 

      }else{

        $ResponseMessage ='Invalid coupon code.';
         return response()->json([
           'response' => 'Failed',     
           'percent_discount' => null,      
           'amount_discount' => null,  
           'required_qty' => null,  
           'min_purchase' => null, 
           'message' => $ResponseMessage,
          ]); 

        }          

    }else{

        $ResponseMessage ='Enter coupon code to validate';
         return response()->json([
           'response' => 'Failed',     
           'percent_discount' => null,      
           'amount_discount' => null,  
           'required_qty' => null,  
           'min_purchase' => null, 
           'message' => $ResponseMessage,
          ]); 
    }

    
    return response()->json($result);     
}

 //EWALLET CREDITS HISTORY===============================================================
  public function getEWalletCreditsHistory(Request $request){

  $EWallet = new EWallet();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['UserID'] = $request->post('UserID');

  $data['Status'] = '';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $result=$EWallet->getEWalletHistoryList($data);  

  return response()->json($result); 
  }

//MESSAGE NOTIFICATION===============================================================
  public function getMessageNotificationList(Request $request){

  $Messages = new Messages();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $data['UserID'] = $request->post('UserID');

  $data['Status'] = '';
  $data['SearchText'] = '';

  $data["PageNo"] = 0;
  $data["Limit"] = 0;

  $result=$Messages->getMessageNotificationList($data);  

  return response()->json($result); 
  }

//CITY LIST==================================================================
 public function getCityList(Request $request){

  $City = new City();

  $response = "Failed";
  $responseMessage = "";

  $data['Platform'] = config('app.PLATFORM_ANDROID'); 
  $result=$City->getNewCityList();  
  return response()->json($result); 
  }

  //EPUB VIEWER================================================================

   public function getShowViewerEpub(Request $request){
     
   $Book= new Book();
   
   $data['Page'] = 'Home';   
   $data['doc_id'] =  $request->input('doc_id');
   
   if($data['doc_id']>0){
       $Epub_file='';
       $info=$Book->getBookInfoByID($data['doc_id']);
       if(isset($info)>0){
           $Epub_file=$info->file_url;
           $Document_URL_File='https://beta.ebooklat.phr.com.ph/public/'.$Epub_file;
           $data['epub_doc']=$Document_URL_File;
          return View::make('front/viewer')->with($data);    
       }else{
           $data['epub_doc']='';
           return View::make('front/viewer')->with($data);    
       }
      
   }else{
       $data['epub_doc']='';
       return View::make('front/viewer')->with($data);    
   }
  
 }


}