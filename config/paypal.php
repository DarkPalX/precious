<?php

return [
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // 'sandbox' or 'live'

    'sandbox' => [
        'client_id'     => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
        'app_id'        => 'APP-80W284485P519543T',
    ],

    'live' => [
        'client_id'     => env('PAYPAL_LIVE_CLIENT_ID'),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
        'app_id'        => env('PAYPAL_LIVE_APP_ID', ''),
    ],

    'payment_action' => 'Sale',  // 'Sale', 'Authorization', or 'Order'
    'currency'       => env('PAYPAL_CURRENCY', 'PHP'),
    'billing_type'   => 'MerchantInitiatedBilling',
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), 
    'return_url'     => env('PAYPAL_RETURN_URL'),  
    'cancel_url'     => env('PAYPAL_CANCEL_URL'),  
    'locale'         => 'en_PH',  // Set to Philippines locale
    'validate_ssl'   => true,     // Ensure SSL validation is enabled
];
