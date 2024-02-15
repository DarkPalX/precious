<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductReview extends Model
{
    use HasFactory, softDeletes;

    public $table = 'product_reviews';
    protected $fillable = ['product_id','user_id','name','email','comment','rating'];
    
}
