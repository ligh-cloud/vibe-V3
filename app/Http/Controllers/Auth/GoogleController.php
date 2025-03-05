<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
// use Auth;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle(){
        return Socialite::driver("google")->redirect();
    }
    public function handleGoogleCallback(){
        $socialUser = Socialite::driver('google')->stateless()->user();
        $user = User::where('google_id', $socialUser->id)->first();
        if ($user) {
            // User exists with the google_id; log them in.
            Auth::login($user);
        } else {
            // Check if a user with the same email exists (duplicate email handling)
            $existingUser = User::where('email', $socialUser->email)->first();
            if ($existingUser) {
                // Update the existing user with the google_id and log them in.
                $existingUser->update(['google_id' => $socialUser->id]);
                Auth::login($existingUser);
            } else {
                // No user exists with this email; create a new user.
                $newUser = User::create([
                    'name'      => $socialUser->name,
                    'email'     => $socialUser->email,
                    'google_id' => $socialUser->id,
                    // Use a random password because Google login doesn't use passwords
                    'password'  => Hash::make(uniqid())
                ]);
                Auth::login($newUser);
            }
        }

        return redirect()->to('/dashboard');
    }
}
