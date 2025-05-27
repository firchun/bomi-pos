<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class SyncController extends Controller
{
    // App\Http\Controllers\Api\SyncController.php
    public function syncUsersWithCloud(Request $request)
    {

        // Step 1: Upload local to cloud
        $localUsers = \App\Models\User::all()->toArray();

        Http::post('https://cloud.bomipos.com/api/upload-users', [
            'users' => $localUsers
        ]);

        // Step 2: Download cloud to local
        $response = Http::get('https://cloud.bomipos.com/api/download-users');
        $cloudUsers = $response->json('users');

        foreach ($cloudUsers as $userData) {
            \App\Models\User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'updated_at' => $userData['updated_at']
                ]
            );
        }

        return response()->json(['message' => 'Sinkronisasi berhasil']);
    }
    public function uploadUsers(Request $request)
    {
        $users = $request->input('users'); // dari local
        $synced = [];

        foreach ($users as $userData) {
            $user = \App\Models\User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'updated_at' => $userData['updated_at']
                ]
            );
            $synced[] = $user;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Users synced from local',
            'synced' => $synced
        ]);
    }
    // Endpoint cloud
    public function downloadUsers(Request $request)
    {
        $tokenValue = $request->header('Authorization');

        $token = \App\Models\LocalServerToken::where('token', $tokenValue)->where('active', true)->first();

        if (! $token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid'
            ], 401);
        }

        // Hanya kirim data user yang sesuai token
        $user = $token->user;

        return response()->json([
            'status' => 'success',
            'users' => [
                [
                    'name' => $user->name,
                    'email' => $user->email,
                    'updated_at' => $user->updated_at,
                ]
            ]
        ]);
    }
}
