<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\MobileAppSetting;

class MobileAppSettingController extends Controller
{

    public function edit()
    {
        $mobile_setting = MobileAppSetting::first();

        return view('admin.settings.mobile-app.index',compact('mobile_setting'));
    }

    public function update(Request $request)
    {
        $setting = MobileAppSetting::first();

        if (!$setting) {
            $setting = new MobileAppSetting();
        }

        $fields = [

            // Splash
            'splashscreen_logo',
            'splashscreen_gif_animation',

            // Onboard
            'onboard_screen_logo_1',
            'onboard_screen_logo_2',
            'onboard_screen_logo_3',

            // Dashboard
            'dashboard_profile_button',
            'dashboard_library_button',
            'dashboard_transactions_button',
            'dashboard_ecredits_button',
            'dashboard_contact_button',
            'dashboard_about_button',
            'dashboard_faqs_button',
            'dashboard_password_button',
            'dashboard_settings_button',

            // Menubar
            'menubar_profile_button',
            'menubar_library_button',
            'menubar_home_button',
            'menubar_orders_button',
            'menubar_messages_button',
        ];

        foreach ($fields as $field) {

            /*
            |--------------------------------
            | REMOVE IMAGE
            |--------------------------------
            */
            if ($request->input('remove_' . $field) == 1) {

                if ($setting->$field) {

                    $path = public_path('storage/mobile/' . $setting->$field);

                    if (file_exists($path)) {
                        unlink($path);
                    }

                    $setting->$field = null;
                }
            }

            /*
            |--------------------------------
            | UPLOAD NEW IMAGE
            |--------------------------------
            */
            if ($request->hasFile($field)) {

                $file = $request->file($field);

                $filename = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('storage/mobile'), $filename);

                $setting->$field = $filename;
            }
        }

        /*
        |--------------------------------
        | ONBOARD TEXT
        |--------------------------------
        */

        for ($i = 1; $i <= 3; $i++) {

            $setting->{'onboard_screen_title_' . $i} =
                $request->input('onboard_screen_title_' . $i);

            $setting->{'onboard_screen_content_' . $i} =
                $request->input('onboard_screen_content_' . $i);
        }

        /*
        |--------------------------------
        | BACKGROUND TYPE
        |--------------------------------
        */

        // FOR BACKGROUND COLOR
        $setting->background_color_info = $request->background_color_info;

        // REMOVE BACKGROUND IMAGE
        if ($request->input('remove_background_img_info') == 1) {

            if ($setting->background_img_info) {

                $path = public_path('storage/mobile/' . $setting->background_img_info);

                if (file_exists($path)) {
                    unlink($path);
                }

                $setting->background_img_info = null;
            }
        }

        // UPLOAD NEW BACKGROUND IMAGE
        if ($request->hasFile('background_img_info')) {

            $file = $request->file('background_img_info');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('storage/mobile'), $filename);

            $setting->background_img_info = $filename;
        }

        // if ($request->background_type == 'color') {

        //     $setting->background_color_info = $request->background_color_info;
        //     $setting->background_img_info = null;
        // }

        // if ($request->background_type == 'image') {

        //     $setting->background_color_info = null;

        //     if ($request->hasFile('background_img_info')) {

        //         $file = $request->file('background_img_info');

        //         $filename = time() . '_' . $file->getClientOriginalName();

        //         $file->move(public_path('storage/mobile'), $filename);

        //         $setting->background_img_info = $filename;
        //     }
        // }

        /*
        |--------------------------------
        | COLORS
        |--------------------------------
        */

        $setting->topbar_bg_color = $request->topbar_bg_color;
        $setting->bottombar_bg_color = $request->bottombar_bg_color;
        $setting->button_bg_color = $request->button_bg_color;
        $setting->font_color = $request->font_color;

        $setting->save();

        return redirect()
            ->back()
            ->with('success', 'Mobile App Settings Updated Successfully.');
    }

    public function reset(Request $request)
    {
        $setting = MobileAppSetting::first();

        if (!$setting) {
            $setting = new MobileAppSetting();
        }

        $setting->splashscreen_logo = env('APP_URL') .'/images/'. 'default_mobile_logo.png';
        $setting->splashscreen_gif_animation = env('APP_URL') .'/images/'. 'default_mobile_animatted_gif.gif';

        $setting->onboard_screen_logo_1 = null;
        $setting->onboard_screen_title_1 = null;
        $setting->onboard_screen_content_1 = null;
        $setting->onboard_screen_logo_2 = null;
        $setting->onboard_screen_title_2 = null;
        $setting->onboard_screen_content_2 = null;
        $setting->onboard_screen_logo_3 = null;
        $setting->onboard_screen_title_3 = null;
        $setting->onboard_screen_content_3 = null;

        $setting->dashboard_profile_button = env('APP_URL') .'/images/'. 'default_mobile_profile_button_icon.png';
        $setting->dashboard_library_button = env('APP_URL') .'/images/'. 'default_mobile_library_button_icon.png';
        $setting->dashboard_transactions_button = env('APP_URL') .'/images/'. 'default_mobile_orders_button_icon.png';
        $setting->dashboard_ecredits_button = env('APP_URL') .'/images/'. 'default_mobile_ecredits_button_icon.png';
        $setting->dashboard_contact_button = env('APP_URL') .'/images/'. 'default_mobile_contact_us_button_icon.png';
        $setting->dashboard_about_button = env('APP_URL') .'/images/'. 'default_mobile_about_us_button_icon.png';
        $setting->dashboard_faqs_button = env('APP_URL') .'/images/'. 'default_mobile_faq_button_icon.png';
        $setting->dashboard_password_button = env('APP_URL') .'/images/'. 'default_mobile_set_password_button_icon.png';
        $setting->dashboard_settings_button = env('APP_URL') .'/images/'. 'default_mobile_app_setting_button_icon.png';

        $setting->menubar_profile_button = env('APP_URL') .'/images/'. 'default_mobile_profile_menu_icon.png';
        $setting->menubar_library_button = env('APP_URL') .'/images/'. 'default_mobile_libray_menu_icon.png';
        $setting->menubar_home_button = env('APP_URL') .'/images/'. 'default_mobile_home_menu_icon.png';
        $setting->menubar_orders_button = env('APP_URL') .'/images/'. 'default_mobile_order_menu_icon.png';
        $setting->menubar_messages_button = env('APP_URL') .'/images/'. 'default_mobile_message_menu_icon.png';
        
        $setting->background_color_info = "#ffffff";
        $setting->background_img_info = env('APP_URL') .'/images/'. 'default_mobile_background.jpg';
        $setting->topbar_bg_color = "#ffffff";
        $setting->bottombar_bg_color = "#ffffff";
        $setting->button_bg_color = "#ffffff";
        $setting->font_color = "#ffffff";

        $setting->save();

         return redirect()->back()->with('success', 'Mobile App Settings Reset Successfully.');
    }

    public function remove_logo(Request $request)
    {

        $field = $request->field;

        $mobile_setting = MobileAppSetting::first();

        Storage::delete('public/mobile/'.$mobile_setting->$field);

        $mobile_setting->$field = null;

        $mobile_setting->save();

        return back()->with('success','Image removed');

    }

}