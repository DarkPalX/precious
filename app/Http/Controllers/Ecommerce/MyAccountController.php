<?php

namespace App\Http\Controllers\Ecommerce;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

use App\Helpers\{PaynamicsHelper};
use App\Models\Ecommerce\{
    Cart, SalesHeader, SalesDetail
};

use App\Models\{
    Page, User
};

use Auth;

class MyAccountController extends Controller
{
    public function manage_account(Request $request)
    {
        $page = new Page;
        $page->name = 'My Account';

        $member = auth()->user();
        $user = auth()->user();

        return view('theme.pages.customer.manage-account', compact('member', 'user', 'page'));
    }

    public function update_personal_info(Request $request)
    {
        $requestData = $request->except(['_token']);
        $requestData['name'] = $request->firstname.' '.$request->lastname;

        User::whereId(Auth::id())->update($requestData);

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

        $page = new Page();
        $page->name = 'Sales Transaction';

        return view('theme.pages.customer.orders',compact('sales','page'));
    }

    public function cancel_order(Request $request){

        $sales = SalesHeader::find($request->orderid);
        $sales->update(['status' => 'CANCELLED', 'delivery_status' => 'CANCELLED']);

        return back()->with('success','Order #:'.$sales->order_number.' has been cancelled.');
    }

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

}
