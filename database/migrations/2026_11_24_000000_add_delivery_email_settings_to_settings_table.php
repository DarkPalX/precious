<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveryEmailSettingsToSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('door_to_door_details')->nullable();
            $table->text('pickup_order_details')->nullable();
            $table->text('ending_inquiry')->nullable();
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'door_to_door_details',
                'pickup_order_details',
                'ending_inquiry',
            ]);
        });
    }
}
