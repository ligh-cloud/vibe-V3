<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use function Termwind\render;

use PhpParser\Node\Stmt\Return_;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Hashids\Hashids;

class FreindController extends Controller
{
    //
    public function addFreind(Request $request)
    {

        $isSent = $this->estEnvoye($request->receiver_id);

        if ($isSent) {
            return redirect('/Suggestions')->with([
                'message' => 'Invitation déjà envoyée',
                'isSent' => true
            ]);
        }


        Invitation::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->userRecu_id,
        ]);

        return redirect('/Suggestions')->with([
            'message' => 'Invitation envoyée avec succès',
            'isSent' => false // Passer la variable isSent
        ]);
    }


    public function estEnvoye($receiver_id)
    {
        return Invitation::where('sender_id', auth()->id())
            ->where('receiver_id', $receiver_id)
            ->exists();

    }

    public function showRequestEnvoye()
    {
        $user = Auth::user();
        $RequestsEnvoyes = $user->receivedInvitations()->get();
        // dd( $RequestsEnvoyes);
        return view('invitations', compact('RequestsEnvoyes'));

    }

    public function AccepterFreind(Request $request)
    {
        $user = Auth::user();
        $user->receivedInvitations()->wherePivot('sender_id', $request->id_sender)->updateExistingPivot($request->id_sender, ['status' => 'accepted']);
        return redirect('/invitations');
    }

    public function RefuserFreind(Request $request)
    {

        $user = Auth::user();
        $user->receivedInvitations()->wherePivot('sender_id', $request->id_sender)->updateExistingPivot($request->id_sender, ['status' => 'rejected']);
        return redirect('/invitations');
    }

    public function Suggestions(Request $request)
    {

        $searchTerm = $request->input('search');
        $query = User::where('id', '!=', auth()->id());
        if ($searchTerm) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('pseudo', 'LIKE', '%' . $searchTerm . '%');
            });
        }
        $users = $query->get();
        return view('Suggestions', compact('users'));
    }

    function mesAmies()
    {
        $user = auth()->user();
        $amis = $user->friends()->get();
        return view('mesamies', compact('amis'));
    }

    public function addFriendFromQr($user)
    {
        try {

            $hashids = new Hashids('friend-qr-salt', 10);
            $decoded = $hashids->decode($user);

            if (empty($decoded)) {
                return redirect()->back()->with('error', 'Invalid QR code.');
            }

            $receiverId = $decoded[0];
            $senderId = auth()->id();

            // Simple validation
            if ($senderId === $receiverId) {
                return redirect()->route('index')->with('error', 'You cannot send an invitation to yourself.');
            }

            // Find the receiver
            $receiver = User::find($receiverId);
            if (!$receiver) {
                return redirect()->route('index')->with('error', 'User not found.');
            }

            $receiver = User::find($receiverId);
            if (!$receiver) {
                return redirect()->route('index')->with('error', 'User not found.');
            }
            Invitation::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'status' => 'accepted'
            ]);

            return redirect('/chatify')->with('success', 'Invitation sent to ' . $receiver->name . '!');

        } catch (\Exception $e) {
            \Log::error('Friend invitation error: ' . $e->getMessage());
            return redirect()->route('index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
