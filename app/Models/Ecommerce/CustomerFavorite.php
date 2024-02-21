<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFavorite extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'customer_id'];

    public static function isFavorite($product_id){
        return self::where('product_id', $product_id)->where('customer_id', auth()->id())->first();
    }
}
