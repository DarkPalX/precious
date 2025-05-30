<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Subscription extends Model
{
    use HasFactory;
    
    protected $table = "subscriptions";
    protected $fillable = ['title', 'price', 'no_days', 'short_description', 'long_description', 'status'];

    public function users_subscriptions()
    {
        return $this->hasMany(UsersSubscription::class, 'plan_id');
    }

    public static function getPlan($id){

        $plan = DB::select( DB::raw("SELECT * FROM subscriptions WHERE id = $id") );

        return $plan;
    }
}
