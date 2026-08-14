<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the Social Provider authentication page.
     */
    public function redirectToProvider($provider)
    {
        $providerKey = strtolower($provider);

        // Request 'email' scope explicitly to maximize chance of returning an email
        return Socialite::driver($providerKey)
            ->scopes(['email'])
            ->redirect();
    }

    /**
     * Obtain the user information from Social Provider.
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $providerKey = strtolower($provider);

        // 1. Handle user cancellation or missing OAuth authorization code
        if ($request->has('error') || ! $request->has('code')) {
            return redirect('/login')->withErrors([
                'msg' => 'Authentication was canceled or failed. Please try again.'
            ]);
        }

        try {
            $socialUser = Socialite::driver($providerKey)->user();
        } catch (Exception $e) {
            Log::error("Socialite Login Error ({$providerKey}): " . $e->getMessage());

            return redirect('/login')->withErrors([
                'msg' => 'Unable to authenticate. Please try again.'
            ]);
        }

        $authUser = $this->findOrCreateUser($socialUser, $providerKey);

        // Log the user in and set "remember me"
        Auth::login($authUser, true);

        return redirect()->intended('/home');
    }

    /**
     * Find an existing user or create a new one safely.
     */
    public function findOrCreateUser($socialUser, $provider)
    {
        $providerId   = $socialUser->getId();
        $providerName = strtolower($provider); // Normalizes for enum ('google','facebook', etc.)
        $socialEmail  = $socialUser->getEmail();

        // 1. Check if user already linked this social account by provider_id
        $authUser = User::where('provider_id', $providerId)->first();
        if ($authUser) {
            return $authUser;
        }

        // Fallback placeholder email if Facebook/OAuth didn't provide one
        $emailToSave = $socialEmail ?: "{$providerId}@{$providerName}.placeholder.com";

        // Wrap database writes in a transaction to handle race conditions safely
        return DB::transaction(function () use ($socialUser, $providerId, $providerName, $socialEmail, $emailToSave) {

            // 2. If a real email was provided, check if standard user already exists
            if ($socialEmail) {
                $existingUser = User::where('email', $socialEmail)->first();

                if ($existingUser) {
                    $existingUser->update([
                        'provider'    => $providerName,
                        'provider_id' => $providerId,
                        'firstname'   => $existingUser->firstname ?? $socialUser->getName() ?? '',
                    ]);

                    return $existingUser;
                }
            }

            // 3. Create a brand new user record
            return User::create([
                'name'         => $socialUser->getName() ?? 'User',
                'firstname'    => $socialUser->getName() ?? 'User',
                'email'        => $emailToSave,
                'provider'     => $providerName,
                'provider_id'  => $providerId,
                'password'     => Hash::make(Str::random(24)),
                'role_id'      => 6,
                'is_active'    => 1,
                'social_login' => 1,
            ]);
        });
    }
}