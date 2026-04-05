<?php

namespace App\Models\APIModels;

use Illuminate\Database\Eloquent\Builder;
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

use App\Models\APIModels\UserAccount;
use App\Models\APIModels\ContentManagement;

class Misc extends Model
{

    public function CheckAppUpdate($request){

        $IsUpdated = true;

        if($request['Platform']){
            $IsUpdated = false;
            if($request['Platform'] == config('app.PLATFORM_ANDROID')){
                if($request['Platform_Version']){
                    if($request['Platform_Version'] == config('app.AndroidLatestVersion') ||
                        $request['Platform_Version'] == config('app.AndroidBetaVersion')){
                        $IsUpdated = true;
                    }
                }
            }elseif($request['Platform'] == config('app.PLATFORM_IOS')){
                if($request['Platform_Version']){
                    if($request['Platform_Version'] == config('app.iOSLatestVersion') ||
                        $request['Platform_Version'] == config('app.iOSBetaVersion')){
                        $IsUpdated = true;
                    }
                }
            }else{
                $IsUpdated = true;
            }
        }

        return $IsUpdated;

    }  

    public function getMobileSettingsInformation(){
 
    $AppSettingID=1;

    $info = DB::table('mobile_app_settings as app_setting')              
    
       ->selectraw("
          app_setting.id as AppSettingID,

          COALESCE(app_setting.splashscreen_logo,'') as splashscreen_logo,
          COALESCE(app_setting.splashscreen_gif_animation,'') as splashscreen_gif_animation,

          COALESCE(app_setting.onboard_screen_logo_1,'') as onboard_screen_logo_1,
          COALESCE(app_setting.onboard_screen_title_1,'') as onboard_screen_title_1,
          COALESCE(app_setting.onboard_screen_content_1,'') as onboard_screen_content_1,

          COALESCE(app_setting.onboard_screen_logo_2,'') as onboard_screen_logo_2,
          COALESCE(app_setting.onboard_screen_title_2,'') as onboard_screen_title_2,
          COALESCE(app_setting.onboard_screen_content_2,'') as onboard_screen_content_2,

          COALESCE(app_setting.onboard_screen_logo_3,'') as onboard_screen_logo_3,
          COALESCE(app_setting.onboard_screen_title_3,'') as onboard_screen_title_3,
          COALESCE(app_setting.onboard_screen_content_3,'') as onboard_screen_content_3,

          COALESCE(app_setting.background_color_info,'') as background_color_info,    
          COALESCE(app_setting.background_img_info,'') as background_img_info,

          COALESCE(app_setting.topbar_bg_color,'') as topbar_bg_color,    
          COALESCE(app_setting.bottombar_bg_color,'') as bottombar_bg_color,

          COALESCE(app_setting.button_bg_color,'') as button_bg_color,
          COALESCE(app_setting.font_color,'') as font_color,

          COALESCE(app_setting.dashboard_profile_button,'') as dashboard_profile_button,
          COALESCE(app_setting.dashboard_library_button,'') as dashboard_library_button,
          COALESCE(app_setting.dashboard_transactions_button,'') as dashboard_transactions_button,
          COALESCE(app_setting.dashboard_ecredits_button,'') as dashboard_ecredits_button,
          COALESCE(app_setting.dashboard_contact_button,'') as dashboard_contact_button,
          COALESCE(app_setting.dashboard_about_button,'') as dashboard_about_button,
          COALESCE(app_setting.dashboard_faqs_button,'') as dashboard_faqs_button,
          COALESCE(app_setting.dashboard_password_button,'') as dashboard_password_button,
          COALESCE(app_setting.dashboard_settings_button,'') as dashboard_settings_button,

          COALESCE(app_setting.menubar_profile_button,'') as menubar_profile_button,
          COALESCE(app_setting.menubar_library_button,'') as menubar_library_button,
          COALESCE(app_setting.menubar_home_button,'') as menubar_home_button,
          COALESCE(app_setting.menubar_orders_button,'') as menubar_orders_button,
          COALESCE(app_setting.menubar_messages_button,'') as menubar_messages_button
                   
          
        ")        
        ->whereRaw('app_setting.id =?',[$AppSettingID])                                      
        ->first();

    return $info;

  }
  
    // ADMIN DATA
    function SetAdminInitialData($data){

        $UserAccount = new UserAccount();
        $data['UserAccountModel'] = $UserAccount;

        return $data;

    }

    function IsAdminLoggedIn(){

        if (!Session('ADMIN_LOGGED_IN')) {
            Session::flash('SessionExpire','Your session has been expired. Please log-in again.');
            return false;
        }

        return true;
    }

  // WEB DATA
  public function SetWebInitialData($data){

    $Misc = new Misc();
    return $data;

 }

 //TRANSACTION LOG
  public function doSaveTransactionLog($data){

        $TODAY = date("Y-m-d H:i:s");
        $TransRefID = $data['TransRefID'];
        $TransactedByID = $data['TransactedByID'];
        $ModuleType = $data['ModuleType'];
        $TransType = $data['TransType'];
        $Remarks = $data['Remarks'];

        DB::table('transactionlog')
            ->insert([
                'TransRefID' => $TransRefID,
                'TransactedByID' => $TransactedByID,
                'TransactionDate' => $TODAY,
                'ModuleType' => $ModuleType,
                'TransType' => $TransType,
                'Remarks' => $Remarks
            ]);
    }

    public function getTransactionLog($data){

        $ModuleType = $data['ModuleType'];
        $TransRefID = $data['TransRefID'];
        $Limit = $data['Limit'];
        $PageNo = $data['PageNo'];

        $query = DB::table('transactionlog as tlog')
            ->join('useraccount as transby', 'transby.UserAccountID', '=', 'tlog.TransactedByID')
            ->selectraw("
                COALESCE(tlog.TransactionID,0) as TransactionID,
                COALESCE(tlog.TransRefID,0) as TransRefID,
                COALESCE(tlog.TransactedByID,0) as TransactedByID,
                CONCAT(COALESCE(transby.FirstName,''),' ',if(COALESCE(transby.MiddleName,'') != '', CONCAT(LEFT(COALESCE(transby.MiddleName,''),1),'. '),''),COALESCE(transby.LastName,'')) as TransactedBy,
                COALESCE(tlog.TransactionDate,'') as TransactionDate,
                COALESCE(tlog.ModuleType,'') as ModuleType,
                COALESCE(tlog.TransType,'') as TransType,
                COALESCE(tlog.Remarks,'') as Remarks
        ");

        if($TransRefID > 0){
            $query->whereRaw("tlog.TransRefID = ?",[$TransRefID]);
        }

        if(!empty($ModuleType)){
            $query->whereRaw("tlog.ModuleType = ?",[$ModuleType]);
        }

        if($Limit > 0){
            $query->limit($Limit);
            $query->offset(($PageNo-1) * $Limit);
        }

        $query->orderByRaw("tlog.TransactionDate DESC");

        $list = $query->get();
    
        return $list;
    }

    public function GetSettingsNextSeriesNo($Field){

        $info = DB::table('transactionno')
          ->selectraw("
            CAST(COALESCE(".$Field.",'0') as SIGNED) as CurrentNo
          ")
          ->whereRaw('ID = ?', [1])
          ->first();  

        if(isset($info)){
          $CurrentNo = $info->CurrentNo + 1;
          $CurrentNo = str_pad($CurrentNo, 5, "0", STR_PAD_LEFT);
          return $CurrentNo;
        }

        return 0;

    }

    public function SetSettingsNextSeriesNo($Field, $CurrentNo){
        $TODAY = date("Y-m-d H:i:s");

        DB::table('transactionno')
          ->whereRaw('ID = ?', [1])
          ->update([
            $Field => $CurrentNo
        ]);

        return true;

    }

    public function GetSystemSettings($SettingsID){

        $info = DB::table('systemsettings')
          ->selectraw("
            COALESCE(SettingValue,'') as SettingValue
          ")
          ->whereRaw('SettingsID = ?', $SettingsID)
          ->first();  

        $SettingValue = '';
        if(isset($info)){
          $SettingValue = $info->SettingValue;
        }

        return $SettingValue;

    }

    public function GenerateRandomNo($Length, $TableName, $FieldName){

        $MinNo = "1";
        $MaxNo = "9";

        for ($i=1; $i < $Length; $i++) {
            $MinNo = $MinNo . '0';
            $MaxNo = $MaxNo . '9';
        }

        $MinNo = $MinNo + 0;
        $MaxNo = $MaxNo + 0;

        $GeneratedNo  = mt_rand($MinNo, $MaxNo);

        if($TableName != '' && !empty($GeneratedNo)){
            $check = DB::table($TableName)
                        ->select($FieldName)
                        ->whereRaw($FieldName.' = ?',[$GeneratedNo])
                        ->first();
            
            if(!isset($check)){
                return $GeneratedNo;
            }else{
                $this->GenerateRandomNo($Length, $TableName, $FieldName);
            }
        }else{
            return $GeneratedNo;
        }
    }

    public function setNumeric($Value){

        $retVal = (empty($Value) ? "0" : $Value);
        $retVal = str_replace(",", "", $retVal);

        if(empty($retVal)){
            $retVal = "0";
        }

        return $retVal;
    }

    public function setRequestValue($Value, $DefaultValue){

        $retVal = $DefaultValue;
        if($Value){
            $retVal = $Value;
        }

        return $retVal;
    }

    public function setMobileNo($Value){

        $Value = str_replace(" ", "", $Value); //Remove Spaces
        $Value = str_replace("-", "", $Value); //Remove Dash

        return $Value;
    }

   public function GenerateRandomString($length) {

    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;

    }

    public function IsValidEmail($Email){

        if(filter_var($Email, FILTER_VALIDATE_EMAIL)){
            return true;
        }

        return false;
    }

    public function getNextOrderNumberFormat(){

     $nxt_order="";
     $info = DB::table('ecommerce_sales_headers')->orderBy('created_at', 'desc')->limit(1)->first();
     if(isset($info)>0){
        $last_order=$info->order_number;
        $order_number=explode("-", $last_order);
        if(!isset($order_number[1])){
            $next_number=date('Ymd')."-0001";    
        }else{
            $next_number=date('Ymd')."-".str_pad(($order_number[1]+1),4,'0',STR_PAD_LEFT);    
        }
     }else{
         $next_number=date('Ymd')."-0001";
     }
     
     return $next_number;

    }

    public function IsValidMobileNo($MobileNo){

        $Response = False;

        $MobileNo = str_replace(" ", "", $MobileNo); //Remove Spaces
        $MobileNo = str_replace("+", "", $MobileNo); //Remove +
        $MobileNo = str_replace("-", "", $MobileNo); //Remove -

        $MobileNoCount = strlen($MobileNo);
        $MobileNoFirst2Char = substr($MobileNo, 0, 2);
        $MobileNoFirst3Char = substr($MobileNo, 0, 3);

        if(!is_numeric($MobileNo)){
            $Response = False;
        }else if($MobileNoFirst2Char == "63"){
            if($MobileNoCount != 12){
                $Response = False;
            }else if($MobileNoFirst3Char != "639"){
                $Response = False;
            }else{
                $Response = True;
            }
        }else if($MobileNoFirst2Char == "09"){
            if($MobileNoCount != 11){
                $Response = False;
            }else{
                $Response = True;
            }
        }else{
            $Response = False;
        }

        return $Response;
    }

    public function isDataExist($TableName, $FieldID, $dataID, $FieldName, $DataField){

        $IsExist = false;
      
        $info = DB::table($TableName)
            ->where($FieldName, $DataField)
            ->first();

        if(isset($info)>0){
            if($dataID > 0){
                if($info->$FieldID != $dataID){
                    $IsExist = true;
                }
            }else{
                $IsExist = true;
            }
        }

        return $IsExist;
    }

    // RESIZE PHOTO
    public function ResizePhoto($data){

        $image_uploaded = $data["ImageUpload"];
        $path = $data["Path"];
        $autoscale = $data["AutoScale"];
        $posx = $data["PosX"];
        $posy = $data["PosY"];
        $width = $data["Width"];
        $height = $data["Height"];
        $max_width = $data["MaxWidth"];
        $max_height = $data["MaxHeight"];
        $filename = $data["FileName"];

        $IsResizeImage = false;
        
        if(isset($data["IsResizeImage"])){
            $IsResizeImage = $data["IsResizeImage"];
        }
        
        switch($_FILES[$image_uploaded]['type'])
        {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($_FILES[$image_uploaded]['tmp_name']);
                break;
            case 'image/png':
                $image = imagecreatefrompng($_FILES[$image_uploaded]['tmp_name']);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($_FILES[$image_uploaded]['tmp_name']);
                break;
            default:
                exit('Unsupported type: '.$_FILES[$image_uploaded]['type']);
        }

        // Get current dimensions
        $old_width  = imagesx($image);
        $old_height = imagesy($image);
        if($IsResizeImage && $old_width > $max_width && ($posx > 0 || $posy > 0 )){

            // Calculate the scaling we need to do to fit the image inside our frame
            $scale = $max_width/$old_width;

            // Get the new dimensions
            $new_width  = ceil($scale*$old_width);
            $new_height = ceil($scale*$old_height);

    //            $posx = ceil($posx * $scale);
    //            $posy = ceil($posy * $scale);
    //            $width = ceil($width * $scale);
    //            $height = ceil($height * $scale);

            // Create new empty image
            $new = imagecreatetruecolor($new_width, $new_height);

            //allow transparency for pngs
            imagealphablending($new, false);
            imagesavealpha($new, true);

            $transparent = imagecolorallocatealpha($new, 255, 255, 255, 127);
            imagefilledrectangle($new, 0, 0, $new_width, $new_height, $transparent);

            // Resize old image into new
            imagecopyresampled($new, $image,
                0, 0, 0, 0,
                $new_width, $new_height, $old_width, $old_height);

            $image = $new;
        }

        if($posx == 0 && $posy == 0){
           $autoscale = true;
        }

        //Actual resizing
        if($autoscale){

            // Get current dimensions
            $old_width  = imagesx($image);
            $old_height = imagesy($image);

            // Calculate the scaling we need to do to fit the image inside our frame
            if($max_width == 0){
                $scale = $max_height/$old_height;
            }elseif($max_height == 0){
                $scale = $max_width/$old_width;
            }else{
                $scale = min($max_width/$old_width, $max_height/$old_height);
            }

            // Get the new dimensions
            if($IsResizeImage && $posx == 0 && $posy == 0){
                $new_width  = ceil($width * $scale);
                $new_height = ceil($height * $scale);
            }else{
                $new_width  = ceil($scale*$old_width);
                $new_height = ceil($scale*$old_height);
            }
        }else{
            $old_width  = ceil($width);
            $old_height = ceil($height);
            $new_width  = ceil($width);
            $new_height = ceil($height);
        }

        // Create new empty image
        $new = imagecreatetruecolor($new_width, $new_height);

        //allow transparency for pngs
        imagealphablending($new, false);
        imagesavealpha($new, true);

        $transparent = imagecolorallocatealpha($new, 255, 255, 255, 127);
        imagefilledrectangle($new, 0, 0, $new_width, $new_height, $transparent);

        // Resize old image into new
        imagecopyresampled($new, $image,
            0, 0, $posx, $posy,
            $new_width, $new_height, $old_width, $old_height);

        $newfilename = $path.$filename;

        #create folder if not exist
        if(!file_exists($path)){mkdir($path ,0777, TRUE);}

        //Delete File if exist
        if(is_file($newfilename)){unlink($newfilename);}

        $file_parts = pathinfo($newfilename);

        switch($file_parts['extension'])
        {
            case "jpg":
                imagejpeg($new, $newfilename);
                break;
            case "png":
                imagepng($new, $newfilename);
                break;
        }

        // Destroy resources
        imagedestroy($image);
        imagedestroy($new);

        return true;

    }

}