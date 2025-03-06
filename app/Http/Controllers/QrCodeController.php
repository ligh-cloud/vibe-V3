<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Hashids\Hashids;

class QrCodeController extends Controller
{
    public function generate(User $user)
    {

        $user = auth()->user();
        $hashids = new Hashids('friend-qr-salt', 10);
        $hashedId = $hashids->encode($user->id);

        $url = URL::temporarySignedRoute(
            'qrcode.addFriend',
            now()->addHours(24),
            ['user' => $hashedId]
        );

        // Generate the QR code with the signed URL
        $qrCode = QrCode::size(200)->generate($url);

        return view('qrcode', compact('qrCode'));
    }
}
