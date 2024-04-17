<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersSubscription extends Model
{
    use HasFactory;

    protected $table = 'users_subscriptions';
    protected $fillable = ['user_id', 'plan_id', 'no_days', 'mode_payment', 'amount_paid', 'start_date', 'end_date', 'is_subscribe', 'is_expired'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public static function getSubscriptions($id){

        $subs = UsersSubscription::where('user_id', $id)->where('is_subscribe', 1)->where('is_expired', 0)->first();

        return $subs;
    }
    
}
