<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppSetting extends Model
{
    use HasFactory;

    protected $table = 'mobile_app_settings';
    protected $fillable = [
        'splashscreen_logo',
        'splashscreen_gif_animation',

        'onboard_screen_logo_1',
        'onboard_screen_title_1',
        'onboard_screen_content_1',

        'onboard_screen_logo_2',
        'onboard_screen_title_2',
        'onboard_screen_content_2',

        'onboard_screen_logo_3',
        'onboard_screen_title_3',
        'onboard_screen_content_3',

        'dashboard_profile_button',
        'dashboard_library_button',
        'dashboard_transactions_button',
        'dashboard_ecredits_button',
        'dashboard_contact_button',
        'dashboard_about_button',
        'dashboard_faqs_button',
        'dashboard_password_button',
        'dashboard_settings_button',

        'menubar_profile_button',
        'menubar_library_button',
        'menubar_home_button',
        'menubar_orders_button',
        'menubar_messages_button',

        'background_color_info',
        'background_img_info',

        'topbar_bg_color',
        'bottombar_bg_color',
        'button_bg_color',
        'font_color',
        'bottom_menu_font_color',
        'bottom_menu_front_color_active',
        'title_and_paragrapgh_font_color',

        'empty_library_icon'
    ];
}
