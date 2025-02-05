<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\ShopProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function adminDashboard()
    {
        // Get all users and shop profiles
        $users = User::where('role', 'user')->get();
        $shopProfiles = ShopProfile::all(); // Get all shop profiles

        return view('pages.messages.AdminMessage', compact('users', 'shopProfiles'));
    }

    public function getAdminMessages(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Validasi ID pengguna yang harus ada di tabel users.
            'last_message_id' => 'nullable|integer', // ID pesan terakhir (opsional) untuk pagination.
        ]);

        // Query untuk mengambil pesan antara admin dan pengguna berdasarkan ID mereka.
        $query = Message::where(function ($query) use ($validated) {
            $query->where('admin_id', Auth::id()) // Pesan dikirim oleh admin.
                ->where('user_id', $validated['user_id']);
        })
            ->orWhere(function ($query) use ($validated) {
                $query->where('user_id', $validated['user_id']) // Pesan dikirim oleh user.
                    ->where('admin_id', Auth::id());
            })
            ->orderBy('created_at', 'asc'); // Urutkan berdasarkan waktu pembuatan (ascending).

        // Jika `last_message_id` diberikan, hanya ambil pesan yang lebih baru dari ID tersebut.
        if ($request->filled('last_message_id')) {
            $query->where('id', '>', $validated['last_message_id']);
        }

        // Ambil pesan berdasarkan query yang telah dibuat.
        $messages = $query->get();

        // Kembalikan pesan dalam format JSON sebagai respons.
        return response()->json(['messages' => $messages]);
    }

    public function sendMessageToUser(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Validasi ID pengguna yang harus valid di tabel users.
            'message' => 'required|string|max:1000', // Validasi pesan dengan panjang maksimum 1000 karakter.
        ]);

        // Membuat pesan baru dalam tabel Message.
        $message = Message::create([
            'admin_id' => Auth::id(), // ID admin yang sedang login.
            'user_id' => $validated['user_id'], // ID pengguna tujuan.
            'message' => $validated['message'], // Isi pesan.
            'is_admin' => true, // Menandakan bahwa pesan dikirim oleh admin.
        ]);

        // Kembalikan pesan yang baru dikirim dalam format JSON.
        return response()->json([
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => $message->is_admin,
                'created_at' => $message->created_at->toDateTimeString(),
            ],
            'status' => 'success',
        ]);
    }

    public function getUnreadCounts()
    {
        $totalUnread = Message::where('is_admin', false)->where('is_read', false)->count();
        $userUnreadCounts = User::withCount(['messages as unread_count' => function ($query) {
            $query->where('is_admin', false)->where('is_read', false);
        }])->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'unreadCount' => $user->unread_count ?? 0,
            ];
        });

        return response()->json([
            'totalUnread' => $totalUnread,
            'userUnreadCounts' => $userUnreadCounts,
        ]);
    }


    public function userDashboard()
    {
        $admins = User::where('role', 'admin')->get();
        return view('pages.messages.UserMessage', compact('admins'));
    }

    // Fetch recent messages between user and admin
    public function getUserMessages(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'last_message_id' => 'nullable|integer',
        ]);

        // Query for fetching messages between user and admin
        $query = Message::where(function ($query) use ($validated) {
            $query->where('user_id', Auth::id())
                ->where('admin_id', $validated['admin_id']);
        })
            ->orWhere(function ($query) use ($validated) {
                $query->where('admin_id', $validated['admin_id'])
                    ->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'asc');

        // If a last message ID is provided, fetch messages after that ID
        if ($request->filled('last_message_id')) {
            $query->where('id', '>', $validated['last_message_id']);
        }

        // Fetch the messages based on the query
        $messages = $query->get();

        // Return the messages in the response
        return response()->json(['messages' => $messages]);
    }

    // Send message from user to admin
    public function sendMessageToAdmin(Request $request)
    {
        $validated = $request->validate([
            'admin_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'user_id' => Auth::id(),
            'admin_id' => $validated['admin_id'],
            'message' => $validated['message'],
            'is_admin' => false, // Indicates that the message was sent by the user
        ]);

        return response()->json([
            'message' => [
                'id' => $message->id,
                'message' => $message->message,
                'is_admin' => $message->is_admin,
                'created_at' => $message->created_at->toDateTimeString(),
            ],
            'status' => 'success',
        ]);
    }
}
