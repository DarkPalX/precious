<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MobileAppSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_app_settings', function (Blueprint $table) {
            $table->id();

            $table->string('splashscreen_logo')->nullable();
            $table->string('splashscreen_gif_animation')->nullable();

            $table->string('onboard_screen_logo_1')->nullable();
            $table->string('onboard_screen_title_1')->nullable();
            $table->string('onboard_screen_content_1')->nullable();

            $table->string('onboard_screen_logo_2')->nullable();
            $table->string('onboard_screen_title_2')->nullable();
            $table->string('onboard_screen_content_2')->nullable();

            $table->string('onboard_screen_logo_3')->nullable();
            $table->string('onboard_screen_title_3')->nullable();
            $table->string('onboard_screen_content_3')->nullable();

            $table->string('dashboard_profile_button')->nullable();
            $table->string('dashboard_library_button')->nullable();
            $table->string('dashboard_transactions_button')->nullable();
            $table->string('dashboard_ecredits_button')->nullable();
            $table->string('dashboard_contact_button')->nullable();
            $table->string('dashboard_about_button')->nullable();
            $table->string('dashboard_faqs_button')->nullable();
            $table->string('dashboard_password_button')->nullable();
            $table->string('dashboard_settings_button')->nullable();

            $table->string('menubar_profile_button')->nullable();
            $table->string('menubar_library_button')->nullable();
            $table->string('menubar_home_button')->nullable();
            $table->string('menubar_orders_button')->nullable();
            $table->string('menubar_messages_button')->nullable();

            $table->string('background_color_info')->nullable();
            $table->string('background_img_info')->nullable();

            $table->string('topbar_bg_color')->nullable();
            $table->string('bottombar_bg_color')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_app_settings');
    }
}
