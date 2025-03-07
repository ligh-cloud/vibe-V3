<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Hashids\Hashids;
class profileController extends Controller
{
    //


public function upload(Request $request)
{
    $validation = $request->validate([
        'image' => 'required|image|',
        'bio'=>'required',
    ]);
    $user = Auth::user();
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('profile_images', 'public');
        $user->profile_image = $imagePath;
        $user->bio=$validation['bio'];
        $user->save();
    }
    return back()->with('message', 'Image de profil mise à jour avec succès !');
}

function ToProfile($id){
    $user= user::find($id);
    $posts=Post::find($id);
    return view('profile',compact('user','posts'));
}

function dashboard(){
    $user=Auth::user();

        $hashids = new Hashids('friend-qr-salt', 10);
        $hashedId = $hashids->encode($user->id);

        $url = URL::temporarySignedRoute(
            'qrcode.addFriend',
            now()->addHours(24),
            ['user' => $hashedId]
        );

        // Generate the QR code with the signed URL
        $qrCode = QrCode::size(200)->generate($url);
        $user=Auth::user();
        $posts = $user->posts()->latest()->get();

        return view('dashboard', compact('qrCode' , 'user' , 'posts'));
}






}
