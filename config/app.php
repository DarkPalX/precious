<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'Asia/Manila',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Laravel\Socialite\SocialiteServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        Webwizo\Shortcodes\ShortcodesServiceProvider::class,
        App\Providers\ShortcodesServiceProvider::class,

        //Laravel File-manager
        UniSharp\LaravelFilemanager\LaravelFilemanagerServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Js' => Illuminate\Support\Js::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Shortcode' => Webwizo\Shortcodes\Facades\Shortcode::class,
        



        // CMS4 Models
        'Album' => App\Models\Album::class,
        'User' => App\Models\User::class,
        'Article' => App\Models\Article::class,
        'ArticleCategory' => App\Models\ArticleCategory::class,
        'Page' => App\Models\Page::class,
        'Menu' => App\Models\Menu::class,
        'MediaAccounts' => App\Models\MediaAccounts::class,
        'ViewPermissions' => App\Models\ViewPermissions::class,
        'ActivityLog' => App\Models\ActivityLog::class,


        // CMS4 Controllers
        'FrontController' => App\Http\Controllers\FrontController::class,
        'DashboardController' => App\Http\Controllers\DashboardController::class,



        // Helper
        'Setting' => App\Helpers\Setting::class,
        'SettingHelper' => App\Helpers\Setting::class,



        // Laravel File-manager
        'Image' => Intervention\Image\Facades\Image::class,


        // Other facades...
        'Socialite' => Laravel\Socialite\Facades\Socialite::class,

    ],


     //API ======================================================

     //COMPANY INFO
    'CompanyName' => 'PRECIOUS PAGES CORP',
    'CompanyEmail'=>'info@preciouspages.com.ph',
    'CompanySupportEmail'=>'',
    'CompanyNoReplyEmail'=>'no-reply@preciouspagesbookstore.com.ph',
    'CompanyMobileNo' => '0922 868 4362',
    'CompanyTelephoneNo' => '8518-7610',
    'CompanyAddress' => '16 JRich Building, Santo Domingo Avenue, corner Pasig City',
    'CompanyShortAddress' => '',

    //Site is On Debug Mode
    'DebugMode' => '0',
    'EmailDebugMode' => '0',

    //PayPal Setting SandBox Environment TEST NI Developer
    // 'PayPalSandBoxEnvironmentMode'=>true,  //TRUE meaning sandbox environment
    // 'PayPalClientID'=>'AeBIXT1-kv9wfiws93iQQLuKMRYKv3ENXhnfixHpeV1xhiCbUvmoGpA4c7JmZqs1E7_WR3lHS_AfxRzH',
    // 'PayPalSecretKey' =>'ENUU_-qN_S9kU3-K8jv8bI16NDQNAWtBFTrevAcHa9wyb0GBDfFuVayafXuzUoeLXES-wnePXnm-gLi3',
    // 'PaypalReturnURL'=>'https://preciouspagesbookstore.com.ph/return',
    // 'PaypalCancelURL'=>'https://preciouspagesbookstore.com.ph/cancel',
    // 'PayPalCurrency'=>'PHP',
    // 'PayPalCountryCode'=>'PH',

    //===========================================================================

    //PayPal Setting Live Environment NI PRECIOUS
    'PayPalSandBoxEnvironmentMode'=>false, //FALSE meaning live environment
    'PayPalClientID'=>'AQA2j0P4zaDuAAp38hP4PxyuvEtiszJBbk65NArwODHigueyFuyypla9TxAWpZvSeZ7QoGQirW9Ezvn6',
    'PayPalSecretKey' =>'EHAkFcrJ_QeYU9fa5lfwL3_WvmFwFJ31GRFOTKD2XJwud5wcSmYtICZp_ns2ud-gzX1VTKeHMhMSvW2F',
    'PaypalReturnURL'=>'https://preciouspagesbookstore.com.ph/return',
    'PaypalCancelURL'=>'https://preciouspagesbookstore.com.ph/cancel',
    'PayPalCurrency'=>'PHP',
    'PayPalCountryCode'=>'PH',

    //SHOW/HIDE SETTING
    'ShowGoogleLogin'=>'N',
    'ShowSubscriptionModule'=>'N',
    'ShowContactUsImageAttach'=>'N',

    //PLATFORM
    'PLATFORM_ANDROID' => 'Android',
    'PLATFORM_IOS' => 'iOS',

    //Android Latest Version
    'AndroidLatestVersion' => '1.0.0',
    'AndroidBetaVersion' => '1.0.0',
    'AndroidUpdateMsg' => 'We have released a new update of Precious App. Please download version 1.0.0 update on Google Play Store.',

    //iOS Latest Version
    'iOSLatestVersion' => '1.00',
    'iOSLatestVersionNew' => '1.00',
    'iOSUpdateMsg' => 'We have released a new update of Precious App. Please download update version 1.0.0 on Apple App Store.',


];
