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
use App\Models\Email;


class UserCustomer extends Model

{
  public function getUserLoginPassword($EmailAddress){
     
    $info = DB::table('users as usrs')      
    ->leftjoin('users_subscriptions as usrs_sub', 'usrs_sub.user_id', '=', 'usrs.id')    
    ->leftjoin('subscriptions as subs', 'subs.id', '=', 'usrs_sub.plan_id')    

       ->selectraw("
          usrs.id as user_ID,

          COALESCE(usrs.firstname,'') as firstname,
          COALESCE(usrs.lastname,'') as lastname,
          COALESCE(usrs.name,'') as fullname,
          COALESCE(usrs.avatar,'') as avatar,

          COALESCE(usrs.email,'') as emailaddress,
          COALESCE(usrs.email_verified_at,'') as email_verified_at,
          COALESCE(usrs.password,'') as password,
          COALESCE(usrs.mobile,'') as mobile,
          COALESCE(usrs.phone,'') as phone,

          COALESCE(usrs.birth_date,'') as birth_date,
          DATE_FORMAT(usrs.birth_date,'%m/%d/%Y') as birth_date_format,

          COALESCE(usrs.address_street,'') as address_street,
          COALESCE(usrs.address_city,'') as address_city,
          COALESCE(usrs.address_municipality,'') as address_municipality,
          COALESCE(usrs.address_province,'') as address_province,
          COALESCE(usrs.address_zip,'') as address_zip,
        
          COALESCE(usrs.ecredits,0) as ecredits,
          COALESCE(usrs.password,'') as password,
          COALESCE(usrs.verification_code,'') as verification_code,
          COALESCE(usrs.remember_token,'') as remember_token,

          COALESCE(subs.title,'') as title_plan,

          COALESCE(usrs_sub.plan_id,0) as plan_id,
          COALESCE(usrs_sub.no_days,'') as no_days,

          COALESCE(usrs_sub.start_date,'') as start_date,
          COALESCE(usrs_sub.end_date,'') as end_date,
          
          COALESCE(usrs_sub.is_subscribe,0) as is_subscribe,
          COALESCE(usrs_sub.is_expired,0) as is_expired,

          COALESCE((
               SELECT 
                   COUNT(cart.qty) FROM 
                      ecommerce_shopping_cart as cart                                    
                  WHERE cart.user_id = usrs.id                           
                  AND cart.qty=0 
                  LIMIT 1
                                              
              )
         ,0) as item_cart,

          COALESCE((
               SELECT 
                   COUNT(mssg_notif.id ) FROM 
                      message_notification as mssg_notif                                    
                  WHERE mssg_notif.user_id = usrs.id                           
                  AND mssg_notif.is_read=0 
                  LIMIT 1
                                              
              )
         ,0) as item_message,

          COALESCE(usrs.is_active,0) as is_active          
          
        ")            
        ->whereRaw('usrs.email =?',[$EmailAddress])        
        ->first();
        
    return $info;

  }

  public function doCheckUserLogin($data){
    
    $IsVerified = "Failed";
    $Platform = $data['Platform'];
     
    $EmailAddress = $data['EmailAddress'];
    $UserPassword = bcrypt($data['Password']);

    $info = DB::table('users as usrs')   
    ->leftjoin('users_subscriptions as usrs_sub', 'usrs_sub.user_id', '=', 'usrs.id')   
    ->leftjoin('subscriptions as subs', 'subs.id', '=', 'usrs_sub.plan_id')     

       ->selectraw("
          usrs.id as user_ID,

          COALESCE(usrs.firstname,'') as firstname,
          COALESCE(usrs.lastname,'') as lastname,
          COALESCE(usrs.name,'') as fullname,
          COALESCE(usrs.avatar,'') as avatar,

          COALESCE(usrs.email,'') as emailaddress,
          COALESCE(usrs.email_verified_at,'') as email_verified_at,
          COALESCE(usrs.password,'') as password,
          COALESCE(usrs.mobile,'') as mobile,
          COALESCE(usrs.phone,'') as phone,

          COALESCE(usrs.birth_date,'') as birth_date,
          DATE_FORMAT(usrs.birth_date,'%m/%d/%Y') as birth_date_format,

          COALESCE(usrs.address_street,'') as address_street,
          COALESCE(usrs.address_city,'') as address_city,
          COALESCE(usrs.address_municipality,'') as address_municipality,
          COALESCE(usrs.address_province,'') as address_province,
          COALESCE(usrs.address_zip,'') as address_zip,
        
          COALESCE(usrs.ecredits,0) as ecredits,
          COALESCE(usrs.verification_code,'') as verification_code,
          COALESCE(usrs.remember_token,'') as remember_token,

          COALESCE(subs.title,'') as title_plan,
          
          COALESCE(usrs_sub.plan_id,0) as plan_id,
          COALESCE(usrs_sub.no_days,'') as no_days,

          COALESCE(usrs_sub.start_date,'') as start_date,
          COALESCE(usrs_sub.end_date,'') as end_date,
          
          COALESCE(usrs_sub.is_subscribe,0) as is_subscribe,
          COALESCE(usrs_sub.is_expired,0) as is_expired,

          COALESCE((
               SELECT 
                   COUNT(cart.qty) FROM 
                      ecommerce_shopping_cart as cart                                    
                  WHERE cart.user_id = usrs.id                           
                  AND cart.qty=0 
                  LIMIT 1
                                              
              )
        ,0) as item_cart,

        COALESCE((
               SELECT 
                   COUNT(mssg_notif.id ) FROM 
                      message_notification as mssg_notif                                    
                  WHERE mssg_notif.user_id = usrs.id                           
                  AND mssg_notif.is_read=0 
                  LIMIT 1
                                              
              )
         ,0) as item_message,

          COALESCE(usrs.is_active,0) as is_active          
          
        ")                
        ->whereRaw('usrs.email =?',[$EmailAddress])                
        ->whereRaw('usrs.password=?',[$UserPassword])
        ->where('usrs.is_active',1)                
        ->first();

    return $info;

  }

  public function doForgotPassword($data){
    
    $Platform = $data['Platform'];

    $usersID=0;
    $EmailAddress = $data['EmailAddress'];

    //GENERATE RANDOM PASSWORD
     $Misc = new Misc();
     $GeneratedTempPassword=$Misc->GenerateRandomNo(4,'users','verification_code');  

     //SET BYCRYPT PASSWORD
     $NewPassword=bcrypt($GeneratedTempPassword);
  
     $usersID = DB::table('users')          
        ->whereRaw('email=?',[$EmailAddress])                                    
        ->value('id');

    if($usersID>0){

          DB::table('users')
              ->whereRaw('id = ?',[$usersID])
               ->update([
                  'password' => $NewPassword
              ]);

            // EMAIL CALL FORGOT PASSWORD               
            $param["EmailAddress"] = $EmailAddress;
            $param["Password"] = $GeneratedTempPassword;
            
            $Email = new Email();
            $Email->SendPasswordResetEmail($param);

    }else{
        return 'Failed';
    }    

    return 'Success';

  }

  public function doChangePassword($data){
    
    $Platform = $data['Platform'];

    $UserID=0;
    $EmailAddress = $data['EmailAddress'];

    //GENERATE RANDOM PASSWORD
     $Misc = new Misc();
     $GeneratedTempPassword=$Misc->GenerateRandomNo(4,'users','verification_code');  

     //SET BYCRYPT PASSWORD
     $NewPassword=bcrypt($GeneratedTempPassword);
  
     $UserID = DB::table('users')          
        ->whereRaw('email=?',[$EmailAddress])                                    
        ->value('id');

    if($UserID>0){

          DB::table('users')
              ->whereRaw('id = ?',[$UserID])
               ->update([
                  'password' => $NewPassword
              ]);

            // EMAIL CALL FORGOT PASSWORD               
            $param["EmailAddress"] = $EmailAddress;
            $param["Password"] = $GeneratedTempPassword;
            
            $Email = new Email();
            $Email->SendPasswordResetEmail($param);

    }else{
        return 'Failed';
    }    

    return 'Success';

  }

  public function doUserChangePassword($data){
    
    $Platform = $data['Platform'];
    
    $UserID = $data['UserID'];
    $NewPassword = $data['NewPassword'];
      
     //SET BYCRYPT PASSWORD
     $NewPassword=bcrypt($NewPassword);
  
    if($UserID>0){
        DB::table('users')
          ->whereRaw('id = ?',[$UserID])
          ->update([
            'password' => $NewPassword
      ]);
                 
    } else{
      return 'Failed';
    } 

    return 'Success';

  }

  public function updateUsersPassword($data){
    
    $chkEmailID=0;
    $usersID=0;
    $EmailAddress = $data['EmailAddress'];
    $CurrentPassword = sha1($data['CurrentPassword']);
    $NewPassword = sha1($data['NewPassword']);
    
    $chkEmailID = DB::table('users')          
          ->whereRaw('email =?',[$EmailAddress])                                      
          ->value('id');

      if($chkEmailID>0){

          $usersID = DB::table('users')          
            ->whereRaw('email=?',[$EmailAddress])                
            ->whereRaw('UserPassword=?',[$CurrentPassword])                
            ->value('id');

            if($usersID>0){
              DB::table('users')
                ->whereRaw('UserAccountID = ?',[$usersID])
                 ->update([
                  'UserPassword' => $NewPassword
                ]);
            }else{
                return 'password-failed';
            }
      }else{
        return 'email-failed';
      }   

    return 'Success';

  }

  public function doVerifyAccount($data){

    $TODAY = date("Y-m-d H:i:s");
          
    $usersID  = $data['UserID'];
    $VerficationCode = $data['VerficationCode'];
        
    if($usersID>0){

      $CurrentVerficationCode = DB::table('users')                    
          ->whereRaw('id =?',[$usersID])                
          ->value('verification_code');  
          
          if($CurrentVerficationCode==$VerficationCode){
                DB::table('users')
                 ->whereRaw('id= ?',[$usersID])
                  ->update([
                      'email_verified_at' => $TODAY
                   ]);
          }else{
              return 'Failed';
          }
      
      }else{
        return 'Failed';
      }   

    return 'Success';

  }

  public function doResendVerificationCode($data){
          
    $Misc=new Misc();   
    $usersID  = $data['UserID'];
    $EmailAddress  = $data['EmailAddress'];
    
    $NewVerificationCode=$Misc->GenerateRandomNo(4,'users','verification_code');
    if($usersID>0){
        DB::table('users')
           ->whereRaw('id = ?',[$usersID])
            ->update([
                'verification_code' =>  $NewVerificationCode
             ]);
             
          //CALL EMAIL HERE NEW ACTIVATION CODE  
          $param["VerificationCode"] = $NewVerificationCode;
          $param["EmailAddress"] = $EmailAddress;
          
          $Email = new Email();
          $Email->reSendVerificationCodeEmail($param);

          
      }else{
        return 'Failed';
      }   

    return 'Success';

  }

   public function getVerificationCodeByID($data){
          
    $VerficationCode='';
    $usersID  = $data['UserID'];

    $VerficationCode = DB::table('users')               
            ->whereRaw('id =?',[$usersID])                                          
            ->value('verification_code');

    return $VerficationCode;

  }

  public function updateCityAddressLocation($data){
    
    $TODAY = date("Y-m-d H:i:s");

    $CityID=0;  
    $AdddressID=0;  

    $usersID  = $data['UserID'];
    $CityName = $data['CityName'];

     if($usersID>0){
                  
          DB::table('users')
             ->whereRaw('id = ?',[$usersID])
              ->update([
                'address_city' => $CityName,                      
          ]);                                                              

     }else{
       return 'Failed';
     }      

    return 'Success';

  }

  public function doRegisterCustomer($data) {

    $Misc  = New Misc();
    $TODAY = date("Y-m-d H:i:s");

    $UserID=$data['UserID'];
    $Platform=$data['Platform'];

    $FirstName=$data['FirstName'];
    $LastName=$data['LastName'];
    $FullName=$data['FullName'];
    
    $EmailAddress=$data['EmailAddress'];
    $MobileNo=$data['MobileNo'];
    $Password=$data['Password'];

    if($UserID> 0){
          DB::table('users')
            ->where('id',$UserID)
            ->update([      
              'firstname' => trim(ucwords($FirstName)),
              'lastname' => trim(ucwords($LastName)),
              'name' => trim(ucwords($FullName)),              
              'email' => trim($data['EmailAddress']), 
              'mobile' => trim($MobileNo),                
              'password' => bcrypt(trim($Password)),              
              'updated_at' => $TODAY
            ]);
          
    }else{
      
      $VerificationCode=$Misc->GenerateRandomNo(4,'users','verification_code');
      $UserID = DB::table('users')
            ->insertGetId([                                    
              'firstname' => trim(ucwords($FirstName)),
              'lastname' => trim(ucwords($LastName)),
              'name' => trim(ucwords($FullName)),              
              'email' => trim($data['EmailAddress']), 
              'mobile' => trim($MobileNo),             
              'password' => bcrypt(trim($Password)),                                  
              'verification_code' => $VerificationCode,
              'provider' => 'none',  
              'role_id' => 6,              
              'is_active' => 1,              
              'created_at' => $TODAY             
            ]);

          // CALL EMAIL HERE FOR REGISTRATION W/ ACTIVATION
          if(!empty($EmailAddress)){      
             $param['FullName']=trim($FullName);
             $param['EmailAddress']=trim($EmailAddress);
             $param['VerificationCode']=$VerificationCode;
             
             $Email = new Email();
             $Email->SendCustomerRegistrationEmail($param);      
          }

       }

    return 'Success';

  }

  public function getCustomerInformation($data){
        
    $UserID = $data['UserID'];   

    $info = DB::table('users as usrs')              
    ->leftjoin('users_subscriptions as usrs_sub', 'usrs_sub.user_id', '=', 'usrs.id') 
    ->leftjoin('subscriptions as subs', 'subs.id', '=', 'usrs_sub.plan_id') 

       ->selectraw("
          usrs.id as user_ID,

          COALESCE(usrs.firstname,'') as firstname,
          COALESCE(usrs.lastname,'') as lastname,
          COALESCE(usrs.name,'') as fullname,
          COALESCE(usrs.avatar,'') as avatar,

          COALESCE(usrs.email,'') as emailaddress,
          COALESCE(usrs.email_verified_at,'') as email_verified_at,
          COALESCE(usrs.password,'') as password,
          COALESCE(usrs.mobile,'') as mobile,
          COALESCE(usrs.phone,'') as phone,

          COALESCE(usrs.birth_date,'') as birth_date,
          DATE_FORMAT(usrs.birth_date,'%m/%d/%Y') as birth_date_format,

          COALESCE(usrs.address_street,'') as address_street,
          COALESCE(usrs.address_city,'') as address_city,
          COALESCE(usrs.address_municipality,'') as address_municipality,
          COALESCE(usrs.address_province,'') as address_province,
          COALESCE(usrs.address_zip,'') as address_zip,

          COALESCE(usrs.ecredits,0) as ecredits,
          COALESCE(usrs.verification_code,'') as verification_code,
          COALESCE(usrs.remember_token,'') as remember_token,

          COALESCE(subs.title,'') as title_plan,

          COALESCE(usrs_sub.plan_id,0) as plan_id,
          COALESCE(usrs_sub.no_days,'') as no_days,

          COALESCE(usrs_sub.start_date,'') as start_date,
          COALESCE(usrs_sub.end_date,'') as end_date,
         
          COALESCE(usrs_sub.is_subscribe,0) as is_subscribe,
          COALESCE(usrs_sub.is_expired,0) as is_expired,

            COALESCE((
               SELECT 
                   COUNT(cart.qty) FROM 
                      ecommerce_shopping_cart as cart                                    
                  WHERE cart.user_id = usrs.id                           
                  AND cart.qty=0 
                  LIMIT 1
                                              
              )
        ,0) as item_cart,

        COALESCE((
               SELECT 
                   COUNT(mssg_notif.id ) FROM 
                      message_notification as mssg_notif                                    
                  WHERE mssg_notif.user_id = usrs.id                           
                  AND mssg_notif.is_read=0 
                  LIMIT 1
                                              
              )
         ,0) as item_message,
        
          COALESCE(usrs.is_active,0) as is_active         
          
        ")        
        ->whereRaw('usrs.id =?',[$UserID])                                      
        ->first();

    return $info;

  }
  

  public function doUpdateCustomerProfile($data) {

    $Misc  = New Misc();
    $TODAY = date("Y-m-d H:i:s");

    $Platform=$data['Platform'];

    $UserID=$data['UserID'];
    
    $FirstName=$data['FirstName'];
    $LastName=$data['LastName'];

    $FullName=$data['FullName'];
    $BirthDate=$data['BirthDate'].' 00:00:00';

    $EmailAddress=$data['EmailAddress'];
    $MobileNo=$data['MobileNo'];

    $StreetAddress=$data['StreetAddress'];
    $CityName=$data['CityName'];
    $ZipCode=$data['ZipCode'];
 
    if($UserID > 0){
        DB::table('users')
          ->where('id',$UserID)
          ->update([      
            'firstname' => trim(ucwords($FirstName)),              
            'lastname' => trim(ucwords($LastName)),              
            'name' => trim(ucwords($FullName)),              
            'email' => trim($EmailAddress), 
            'birth_date' => $BirthDate, 
            'mobile' => trim($MobileNo),
            'address_street' => $StreetAddress,                                      
            'address_city' => $CityName,
            'address_zip' => $ZipCode,                                       
            'updated_at' => $TODAY
        ]);        
    }

    return 'Success';

  }

  public function doUpdateCustomerAddress($data) {

    $Misc  = New Misc();
    $TODAY = date("Y-m-d H:i:s");
    
    $CityID=0;
    $Platform=$data['Platform'];

    $UserID=$data['UserID'];    
    
    $StreetAddress=$data['StreetAddress'];
    $CityName=$data['CityName'];
    $ZipCode=$data['ZipCode'];

    if($UserID > 0){

        DB::table('users')
          ->where('id',$UserID)
          ->update([      
            'address_street' => $StreetAddress,                                      
            'address_city' => $CityName,
            'address_zip' => $ZipCode,                        
        ]);

    }else{
         return 'Failed';   
    }        

    return 'Success';
  }


}