<?php

namespace App\Models;

use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Session;
use Hash;
use View;
use Input;
use Image;
use DB;

use App\Models\Misc;
use App\Models\Code;

class Email extends Model
{


  //CUSTOMER NOTIF-----------------------------
  	public function SendCustomerRegistrationEmail($param){

	    $EmailAddress = $param['EmailAddress'];
	    if (filter_var($EmailAddress, FILTER_VALIDATE_EMAIL) && config('app.EmailDebugMode') == '0'){
	      Mail::send(
	        'emails/member-registration',
	        [
              'FullName'=> $param['FullName'],
              'VerificationCode'=> $param['VerificationCode']
	        ],
	        function($message) use ($EmailAddress){
	          $message->from(config('app.CompanyNoReplyEmail'));
	          $message->to($EmailAddress);
	          $message->subject('Registration');
	        }
	      );
	    }
  	}
  	

  	 public function reSendVerificationCodeEmail($param){

	     $EmailAddress = $param['EmailAddress'];
	    if (filter_var($EmailAddress, FILTER_VALIDATE_EMAIL) && config('app.EmailDebugMode') == '0'){
	      Mail::send(
	        'emails/resend-verification-code',
	        [                  
                 'VerificationCode'=> $param['VerificationCode']
	        ],
	        function($message) use ($EmailAddress){
	          $message->from(config('app.CompanyNoReplyEmail'));
	          $message->to($EmailAddress);
	          $message->subject('Resend Verification Code');
	        }
	      );
	    }
  	}


	public function SendPasswordResetEmail($param){

	     $EmailAddress = $param['EmailAddress'];
	    if (filter_var($EmailAddress, FILTER_VALIDATE_EMAIL) && config('app.EmailDebugMode') == '0'){
	      Mail::send(
	        'emails/reset-password-email',
	        [                  
                  'Password'=> $param['Password']
	        ],
	        function($message) use ($EmailAddress){
	          $message->from(config('app.CompanyNoReplyEmail'));
	          $message->to($EmailAddress);
	          $message->subject('Password Reset');
	        }
	      );
	    }
  	}

   public function SendContactUsEmail($param){

	    $param["AdminEmailAddress"]=config('app.CompanyEmail');
    	$param["CompanyNoReplyEmail"]=config('app.CompanyNoReplyEmail');

	    if (filter_var($param['EmailAddress'], FILTER_VALIDATE_EMAIL) && config('app.EmailDebugMode') == '0'){
	      Mail::send(
	        'emails/contact-us-email',
	        [                  
             'FullName'=> $param['FullName'],
             'Subject'=> $param['Subject'],
             'EmailAddress'=> $param['EmailAddress'],
             'MobileNo'=> $param['MobileNo'],
             'Message'=> $param['Message']
	        ],
	        function($message) use ($param){
	          $message->from($param['CompanyNoReplyEmail']);
	          $message->to($param["EmailAddress"]);
	          $message->bcc($param['AdminEmailAddress']);
	          $message->subject('Contact Us - Inquiry');
	        }
	      );
	    }
  	}
  	
    public function SendOrderReceivedEmail($param){
              
	   //$param["CompanyEmailAddress"]=config('app.CompanyEmail');
    	$param["CompanyNoReplyEmail"]=config('app.CompanyNoReplyEmail');

	    if (filter_var($param['EmailAddress'], FILTER_VALIDATE_EMAIL) && config('app.EmailDebugMode') == '0'){
	      Mail::send(
	         'emails/send-order-receive-email',
	        [                  
                  'OrderInfo'=> $param['OrderInfo'],
	                'OrderItem'=> $param['OrderItem']	
	        ],
	        function($message) use ($param){
	          $message->from($param["CompanyNoReplyEmail"]);
	          $message->to($param['EmailAddress']);
	          $message->subject('Order #'.$param['OrderNo']." has been placed.");
	        }
	      );
	    }
  	}
  	
  	

}