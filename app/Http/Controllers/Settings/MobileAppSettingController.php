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

        if ($request->background_type == 'color') {

            $setting->background_color_info = $request->background_color_info;
            $setting->background_img_info = null;
        }

        if ($request->background_type == 'image') {

            $setting->background_color_info = null;

            if ($request->hasFile('background_img_info')) {

                $file = $request->file('background_img_info');

                $filename = time() . '_' . $file->getClientOriginalName();

                $file->move(public_path('storage/mobile'), $filename);

                $setting->background_img_info = $filename;
            }
        }

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