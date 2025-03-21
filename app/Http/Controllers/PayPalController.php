<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Exception;

class PayPalController extends Controller
{
    public function createPayment()
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));

            $paypal = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => config('paypal.currency', 'PHP'),
                            "value" => "100.00"  // Replace with dynamic value
                        ]
                    ]
                ],
                "application_context" => [
                    "cancel_url" => config('paypal.cancel_url'),
                    "return_url" => config('paypal.return_url'),
                ]
            ]);

            // Log PayPal response for debugging
            \Log::info('PayPal Response:', $paypal);

            if (isset($paypal['id']) && $paypal['id'] != null) {
                foreach ($paypal['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('paypal.cancel')->with('error', 'Something went wrong.');
        } catch (Exception $e) {
            \Log::error('Error in createPayment: ' . $e->getMessage());
            return redirect()->route('paypal.cancel')->with('error', $e->getMessage());
        }
    }


    // Create PayPal payment
    // public function createPayment()
    // {
    //     try {
    //         $provider = new PayPalClient;
            
    //         // Use the correct PayPal environment
    //         $provider->setApiCredentials(config('paypal'));

    //         // Create PayPal order
    //         $paypal = $provider->createOrder([
    //             "intent" => "CAPTURE",
    //             "purchase_units" => [
    //                 [
    //                     "amount" => [
    //                         "currency_code" => config('paypal.currency', 'PHP'),  // Use config for currency
    //                         "value" => "100.00"  // Replace with dynamic value
    //                     ]
    //                 ]
    //             ],
    //             "application_context" => [
    //                 "cancel_url" => config('paypal.cancel_url'),  // Use config instead of env
    //                 "return_url" => config('paypal.return_url'),  // Use config instead of env
    //             ]
    //         ]);

    //         // Redirect to PayPal approval URL
    //         if (isset($paypal['id']) && $paypal['id'] != null) {
    //             foreach ($paypal['links'] as $link) {
    //                 if ($link['rel'] === 'approve') {
    //                     return redirect()->away($link['href']);
    //                 }
    //             }
    //         }

    //         return redirect()->route('paypal.cancel')->with('error', 'Something went wrong.');

    //     } catch (Exception $e) {
    //         return redirect()->route('paypal.cancel')->with('error', $e->getMessage());
    //     }
    // }

    // Handle PayPal success
    public function success(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));

            $token = $request->query('token');

            // Capture the payment
            $response = $provider->capturePaymentOrder($token);

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                return redirect()->route('home')->with('success', 'Payment successful!');
            }

            return redirect()->route('paypal.cancel')->with('error', 'Payment failed.');

        } catch (Exception $e) {
            return redirect()->route('paypal.cancel')->with('error', $e->getMessage());
        }
    }

    // Handle PayPal cancellation
    public function cancel()
    {
        return redirect()->route('home')->with('error', 'You have cancelled the payment.');
    }
}
