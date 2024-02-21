<?php

namespace App\Http\Controllers\Ecommerce;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Ecommerce\CustomerFavorite;

class CustomerFavoriteController extends Controller
{
    public function store(Request $request){

        $favorite_exists = CustomerFavorite::where('product_id', $request->product_id)->where('customer_id', auth()->id())->first();
        
        if($favorite_exists){
            CustomerFavorite::where('product_id', $request->product_id)->where('customer_id', auth()->id())->delete();
        }
        else{
            $newData['product_id'] = $request->product_id;
            $newData['customer_id'] = auth()->id();

            CustomerFavorite::create($newData);
        }

        return redirect()->back();

    }
}
