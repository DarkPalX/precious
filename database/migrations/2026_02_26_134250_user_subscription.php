<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserSubscription extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('plan_id');
            $table->integer('no_days');
            $table->string('mode_payment');
            $table->decimal('amount_paid', 16,2);
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('is_subscribe')->default(0);
            $table->tinyInteger('is_expired')->default(0);
            $table->tinyInteger('is_extended')->default(0);
            $table->tinyInteger('is_cancelled')->default(0);
            $table->string('cancel_reason');
            $table->string('remarks');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_subscriptions');
    }
}
