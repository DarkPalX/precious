<?php

namespace App\Models\Ecommerce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BannerAd extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'file_url', 'url', 'status', 'click_counts', 'expiration_date'];
    
    public function get_image_file_name()
    {
        $path = explode('/', $this->file_url);
        $nameIndex = count($path) - 1;
        if ($nameIndex < 0)
            return '';

        return $path[$nameIndex];
    }
}
