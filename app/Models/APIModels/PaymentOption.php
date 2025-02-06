<?php

namespace App\Models\APIModels;

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

use App\Models\APIModels\Misc;

class PaymentOption extends Model
{

	public function getPaymentOptionList($param){

		$Status = $param['Status'];

		$query = DB::table('mobile_payment_option as mop')
			->selectraw("
				mop.PaymentOptionID,

				COALESCE(mop.Code,'') as Code,
				COALESCE(mop.ModeOfPayment,'') as ModeOfPayment,
				COALESCE(mop.Status,'') as Status
			");

		if($Status != ''){
			$query->where("mop.Status",$Status);
		}

		$query->orderBy("mop.PaymentOptionID","ASC");

		$list = $query->get();

		return $list;

	}

	public function getPaymentOptionInfo($ModeOfPaymentID){

		$info = DB::table('mobile_payment_option as mop')
			->selectraw("
				mop.PaymentOptionID,

				COALESCE(mop.Code,'') as Code,
				COALESCE(mop.ModeOfPayment,'') as ModeOfPayment,
				COALESCE(mop.Status,'') as Status
			")
			->where("mop.PaymentOptionID",$ModeOfPaymentID)
			->first();

		return $info;

	}



}

