<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdFreeSetting extends Model
{
    protected $table = 'ad_free_settings';

    public $timestamps = false;

    protected $fillable = [
        'date_from',
        'date_to',
        'time_from',
        'time_to',
    ];
}
