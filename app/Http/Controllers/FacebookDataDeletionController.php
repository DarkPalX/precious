<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FacebookDataDeletionController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Handle GET requests for browser/Meta validation
        if ($request->isMethod('get')) {
            return response()->json([
                'message' => 'To delete your data, please remove the app via your Facebook Settings > Apps and Websites.'
            ]);
        }

        // 2. Validate that signed_request exists (POST request)
        $signedRequest = $request->input('signed_request');
        if (!$signedRequest) {
            return response()->json(['error' => 'Missing signed request'], 400);
        }

        // Split and decode the signed request
        list($encodedSig, $payload) = explode('.', $signedRequest, 2);
        $sig = base64_decode(strtr($encodedSig, '-_', '+/'));
        $data = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);

        // Validate the signature using your App Secret
        $expectedSig = hash_hmac('sha256', $payload, env('FACEBOOK_CLIENT_SECRET'), true);
        if ($sig !== $expectedSig) {
            Log::warning('Invalid signature for Facebook data deletion request', ['signed_request' => $signedRequest]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Extract user ID from payload
        $userId = $data['user_id'] ?? null;
        if (!$userId) {
            return response()->json(['error' => 'User ID not found in request'], 400);
        }

        // 3. Find user by provider_id and provider type (matches your Socialite setup)
        $user = User::where('provider_id', $userId)
                    ->where('provider', 'facebook')
                    ->first();

        if ($user) {
            $user->delete(); // Soft deletes if your model uses the SoftDeletes trait
            Log::info('User social data deletion processed', ['provider_id' => $userId]);
        } else {
            // Note: We return 200 even if user not found to satisfy Meta's crawler in some cases, 
            // but logging the warning for your own debugging.
            Log::warning('User not found for deletion', ['facebook_id' => $userId]);
        }

        // 4. Return the specific JSON format Facebook requires
        return response()->json([
            'url' => route('facebook.data-deletion'), // Must be a valid URL
            'confirmation_code' => $userId,
        ]);
    }
}