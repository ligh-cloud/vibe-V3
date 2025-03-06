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
        $socialUser = Socialite::driver('google')->user();
        $user = User::where('google_id', $socialUser->id)->first();
        if ($user) {
            Auth::login($user);
        } else {
            $existingUser = User::where('email', $socialUser->email)->first();
            if ($existingUser) {
                $existingUser->update(['google_id' => $socialUser->id]);
                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name'      => $socialUser->name,
                    'email'     => $socialUser->email,
                    'google_id' => $socialUser->id,
                    'password'  => Hash::make(uniqid())
                ]);
                Auth::login($newUser);
            }
        }

        return redirect()->to('/dashboard');
    }
}
