<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
//    public function generate()
//    {
//        // Generate QR code with text "Hello, Laravel 11!"
//        $qrCode = QrCode::size(300)->generate('Hello, Laravel 11!');
//
//        return response($qrCode)->header('Content-Type', 'image/svg+xml');
//    }

    public function generate(User $user)
    {
            $hashids = new Hashids('your-secret-salt', 10);
        $hashedId = $hashids->encode($user->id);
        $url = URL::signedRoute('invite' , ['user' => $hashedId], now()->addMinutes(30));
        $qrCode = QrCode::size(300)->generate(route('qrcode.addFriend', ['user' => $user->id]));
        return view('qrcode', compact('qrCode'));
    }
}
