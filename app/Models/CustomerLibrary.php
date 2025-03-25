<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Ecommerce\{
    Product
};

use Auth;

class CustomerLibrary extends Model
{
    use HasFactory;
    
    protected $table = "customer_libraries";
    protected $fillable = ['product_id', 'user_id', 'is_admin_selected'];

    public static function already_purchased($product_id){

        $product = Product::where('id', $product_id)->first();

        if (in_array(strtolower($product->book_type), ['e-book', 'ebook']) && Auth::user()) {
            $r = CustomerLibrary::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
            if($r){
                return false;
            }
            else{
                return true;
            }
        }
        else{
            return true;
        }

    }

}
