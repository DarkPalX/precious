<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ecredit extends Model
{
    use HasFactory;

    protected $table = 'ecredits';
    protected $fillable = ['user_id', 'used_credits', 'added_credits', 'balance'];
}
