<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
            ->get();
        return view('pages.subscription.index', compact('users'));
    }
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
        $user->update([
            'is_subscribed' => true,
            'subscription_expires_at' => now()->addMonth(), // atau addDays(30)
        ]);

        return redirect()->route('home')->with('success', 'Berlangganan berhasil!');
    }
    public function update(Request $request)
    {
        foreach ($request->subscriptions as $userId => $data) {
            $user = User::find($userId);

            $user->is_subscribed = isset($data['subscribed']);
            $user->subscription_expires_at = $data['expired'] ?? null;
            $user->save();
        }

        return redirect()->route('subscription.index')->with('success', 'Langganan berhasil diperbarui.');
    }
    public function updatePro(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $user->is_subscribed = 1;
        $user->subscription_expires_at = $request->expired ?? null;
        $user->save();

        if ($user) {
            Notification::create([
                'id_user' => $userId,
                'message' => 'Congratulations! Your account has been upgraded to Pro' .
                    ($request->expired ? ' until ' . \Carbon\Carbon::parse($request->expired)->format('F j, Y') : '.'),
                'read_at' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Subscription updated successfully.');
    }
}
