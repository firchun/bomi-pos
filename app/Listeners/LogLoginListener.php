<?php

namespace App\Listeners;

use App\Models\SecurityLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Request;

class LogLoginListener
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $event
     * @return void
     */
    public function handle(Login $event)
    {

        SecurityLog::create([
            'id_user'    => $event->user->id,
            'type'       => 'login',
            'description' => 'User logged in.',
            'ip_address' => Request::ip(),
            'data'       => json_encode([
                'ip' => Request::ip(),
                'user_agent' => Request::header('User-Agent'),
            ]),
        ]);
    }
}
