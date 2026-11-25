<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGenre extends Model
{
    use SoftDeletes;

    protected $table = 'product_genres';
    protected $fillable = ['name', 'slug', 'status', 'created_by'];
}
