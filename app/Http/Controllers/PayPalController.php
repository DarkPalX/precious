<?php

namespace App\Http\Controllers;

use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Http\Request;
use Exception;
use DB;

use App\Http\Controllers\Ecommerce\{
    MyAccountController, CartController
};

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
            $transaction = $request->transaction;
            $user_id = $request->user_id;
            $amount_paid = $request->amount_paid;

            // Store the params in session to access them in the success route
            session([
                'transaction' => $transaction,
                'user_id' => $user_id,
                'amount_paid' => $amount_paid,
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
                $transaction = session('transaction');
                $user_id = session('user_id');
                $amount_paid = session('amount_paid');

                // Store PayPal response in the database
                DB::table('paypal_payment')->insert([
                    'user_id' => $user_id,
                    'paypal_param_response' => json_encode($response),  // Store full response
                    'Status' => 'Success',
                    'payment_date_time' => now(),
                ]);

                // Retrieve the session data
                $paypalRequest = session('paypal_request', []);
                $paypalRequestObj = new Request($paypalRequest);

                // ✅ Call the static subscription process
                if($transaction == "subscription"){
                    MyAccountController::subscription_process($paypalRequestObj);
                }
                if($transaction == "sales"){
                    CartController::save_sales_process($paypalRequestObj);
                }

                // Clear session variables
                session()->forget(['transaction', 'user_id', 'amount_paid']);

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
