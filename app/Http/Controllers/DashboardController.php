<?php

namespace App\Http\Controllers;

use App\Jobs\RefreshBelowStockProducts;
use Illuminate\Http\Request;


use \App\Models\ActivityLog;


use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
		// Refresh the cached below-stock list whenever the admin dashboard loads.
		(new RefreshBelowStockProducts)->handle();

    	if(Auth::user()->role_id == '6'){
    		Auth::logout();
    		return back()->with('error','Restricted access');
    	}

    	$logs = ActivityLog::where('log_by', auth()->id())->orderBy('id','desc')->paginate(15);

        return view('admin.dashboard.index',compact('logs'));
    }
}
