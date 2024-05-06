<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Carbon\Carbon;

class UsersSubscription extends Model
{
    use HasFactory;

    protected $table = 'users_subscriptions';
    protected $fillable = ['user_id', 'plan_id', 'no_days', 'mode_payment', 'amount_paid', 'start_date', 'end_date', 'is_subscribe', 'is_expired', 'is_extended', 'is_cancelled', 'is_cancelled', 'remarks'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public static function getSubscriptions($id){

        $subs = UsersSubscription::where('user_id', $id)->where('end_date', '>', Carbon::now())->get();

        return $subs;
    }
    
}
