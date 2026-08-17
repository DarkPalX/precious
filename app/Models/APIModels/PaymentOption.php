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

use Session;
use Hash;
use View;
use Input;
use Image;

use App\Models\APIModels\Misc;

class PaymentOption extends Model
{

	// public function getPaymentOptionList($param){

	// 	$Status = $param['Status'];

	// 	$query = DB::table('mobile_payment_option as mop')
	// 		->selectraw("
	// 			mop.PaymentOptionID,

	// 			COALESCE(mop.Code,'') as Code,
	// 			COALESCE(mop.ModeOfPayment,'') as ModeOfPayment,
	// 			COALESCE(mop.ImageIcon,'') as ImageIcon,
	// 			COALESCE(mop.Status,'') as Status
	// 		");

	// 	if($Status != ''){
	// 		$query->where("mop.Status",$Status);
	// 	}

	// 	$query->orderBy("mop.PaymentOptionID","ASC");

	// 	$list = $query->get();

	// 	return $list;

	// }

	// public function getPaymentOptionInfo($ModeOfPaymentID){

	// 	$info = DB::table('mobile_payment_option as mop')
	// 		->selectraw("
	// 			mop.PaymentOptionID,

	// 			COALESCE(mop.Code,'') as Code,
	// 			COALESCE(mop.ModeOfPayment,'') as ModeOfPayment,
	// 			COALESCE(mop.ImageIcon,'') as ImageIcon,
	// 			COALESCE(mop.Status,'') as Status
	// 		")
	// 		->where("mop.PaymentOptionID",$ModeOfPaymentID)
	// 		->first();

	// 	return $info;

	// }

   public function getPaymentOptionList($param){

    $Status = $param['Status'];

    $cacheKey = 'payment_option_list_' . ($Status !== '' ? $Status : 'all');

    return Cache::remember(
        $cacheKey,
        now()->addMinutes(40),
        function () use ($Status) {

            $query = DB::table('mobile_payment_option as mop')
                ->selectraw("
                    mop.PaymentOptionID,

                    COALESCE(mop.Code,'') as Code,
                    COALESCE(mop.ModeOfPayment,'') as ModeOfPayment,
                    COALESCE(mop.ImageIcon,'') as ImageIcon,
                    COALESCE(mop.Status,'') as Status
                ");

            if($Status != ''){
                $query->where("mop.Status", $Status);
            }

            $query->orderBy("mop.PaymentOptionID", "ASC");

            return $query->get();
        }
    );
  }

  public function getPaymentOptionInfo($ModeOfPaymentID){

    $cacheKey = 'payment_option_info_' . $ModeOfPaymentID;

    return Cache::remember(
        $cacheKey,
        now()->addMinutes(40),
        function () use ($ModeOfPaymentID) {

            return DB::table('mobile_payment_option as mop')
                ->selectraw("
                    mop.PaymentOptionID,

                    COALESCE(mop.Code,'') as Code,
                    COALESCE(mop.ModeOfPayment,'') as ModeOfPayment,
                    COALESCE(mop.ImageIcon,'') as ImageIcon,
                    COALESCE(mop.Status,'') as Status
                ")
                ->where("mop.PaymentOptionID", $ModeOfPaymentID)
                ->first();
        }
    );
  }

}

