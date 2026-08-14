<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        // Removed stateless() here to ensure session consistency for web login
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            // Using standard user() for web apps; use stateless() ONLY if using a separate frontend (like React/Vue)
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            // Log the error so you can see why it failed in storage/logs/laravel.log
            \Log::error("Socialite Login Error: " . $e->getMessage());
            return redirect('/login')->withErrors(['msg' => 'Authentication failed. Please try again.']);
        }

        $authUser = $this->findOrCreateUser($socialUser, $provider);
        
        // Log the user in and "remember" them
        Auth::login($authUser, true);

        // Clear session and redirect to home
        return redirect()->intended('/home');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // 1. Check if user already linked this social account
        $authUser = User::where('provider_id', $socialUser->getId())->first();
        
        if ($authUser) {
            return $authUser;
        }

        // 2. Check if the email exists but isn't linked to a provider yet
        // This prevents the "Duplicate Entry" error
        $existingUser = User::where('email', $socialUser->getEmail())->first();

        if ($existingUser) {
            $existingUser->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                // Update name if it was missing
                'firstname' => $existingUser->firstname ?? $socialUser->getName(),
            ]);
            return $existingUser;
        }

        // 3. Create a brand new user
        return User::create([
            'name' => $socialUser->getName(),
            'firstname' => $socialUser->getName(),
            'email' => $socialUser->getEmail(),
            'provider' => $provider,
            'provider_id' => $socialUser->getId(),
            // Secure random password since they use Social Login
            'password' => Hash::make(Str::random(24)), 
            'role_id' => 6,
            'is_active' => 1,
            'social_login' => 1,
        ]);
    }
}

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\Auth;
// use Laravel\Socialite\Facades\Socialite;
// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;

// class SocialiteController extends Controller
// {
//     public function redirectToProvider($provider)
//     {
//         return Socialite::driver($provider)->redirect();
//     }

//     public function handleProviderCallback($provider)
//     {
//         try {
//             $socialUser = Socialite::driver($provider)->stateless()->user();
//         } catch (\Exception $e) {
//             return redirect('/login')->withErrors(['msg' => 'Unable to login using ' . ucfirst($provider) . '. Please try again.']);
//         }

//         $authUser = $this->findOrCreateUser($socialUser, $provider);
//         Auth::login($authUser, true);

//         return redirect()->intended('/home');
//     }

//     public function findOrCreateUser($socialUser, $provider)
//     {
//         $authUser = User::where('provider_id', $socialUser->id)->first();
//         if ($authUser) {
//             return $authUser;
//         }

//         return User::create([
//             'name' => $socialUser->name,
//             'firstname' => $socialUser->name,
//             'email' => $socialUser->email,
//             'provider' => $provider,
//             'provider_id' => $socialUser->id,
//             'password' => Hash::make('password'),
//             'role_id' => 1,
//             'is_active' => 1,
//         ]);
//     }
// }

