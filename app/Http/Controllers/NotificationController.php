<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('id_user', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.notification.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)->where('id_user', Auth::id())->firstOrFail();
        $notification->read_at = now();
        $notification->save();

        return redirect()->route('notifications.index')->with('success', 'Notification marked as read.');
    }
    public function getNotifications(Request $request)
    {
        $notifications = Notification::query()
            ->where('id_user', Auth::id())
            ->where('read_at', null)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $notifications,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $notification = Notification::create([
            'id_user' => $request->id_user,
            'message' => $request->message,
            'read_at' => null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Notification created successfully.',
            'data' => $notification,
        ]);
    }
}
