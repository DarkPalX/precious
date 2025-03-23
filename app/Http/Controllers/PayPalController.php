<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Exception;
use DB;

class PayPalController extends Controller
{

    // Create PayPal payment
    public function createPayment(Request $request)
    {
        try {
            $provider = new PayPalClient;
            
            // Forcefully retrieve the access token
            $provider->getAccessToken();

            // Capture dynamic data from the request
            $user_id = $request->id;
            $amount_paid = $request->amount_paid;
            $sales_header_id = $request->sales_header_id;

             // Store the params in session to access them in the success route
            session([
                'user_id' => $user_id,
                'amount_paid' => $amount_paid,
                'sales_header_id' => $sales_header_id,
            ]);

            $paypal = $provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => config('paypal.currency', 'PHP'),
                            "value" => $amount_paid
                        ]
                    ]
                ],
                "application_context" => [
                    "cancel_url" => config('paypal.cancel_url'),
                    "return_url" => config('paypal.return_url'),
                ]
            ]);

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

                // Retrieve session variables
                $user_id = session('user_id');
                $amount_paid = session('amount_paid');
                $sales_header_id = session('sales_header_id');

                // Store PayPal response in the database
                DB::table('paypal_payment')->insert([
                    'user_id' => $user_id,
                    'paypal_param_response' => json_encode($response),  // Store full response
                    'sales_header_id' => $sales_header_id,
                    'Status' => 'Success',
                    'payment_date_time' => now(),
                ]);

                // Clear session variables
                session()->forget(['user_id', 'amount_paid', 'sales_header_id']);

                return redirect()->route('home')->with('success', 'Payment successful!');
            }

            return redirect()->route('paypal.cancel')->with('error', 'Payment failed.');

        } catch (Exception $e) {
            \Log::error('Error in success: ' . $e->getMessage());
            return redirect()->route('paypal.cancel')->with('error', $e->getMessage());
        }
    }

    // Handle PayPal cancellation
    public function cancel()
    {
        return redirect()->route('home')->with('error', 'You have cancelled the payment.');
    }
}
