<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\SecurityLog;

class SecurityLogService
{
  public static function logLogin($user)
  {
    self::createLog($user, 'login', 'User logged in.');
  }

  public static function logLogout($user)
  {
    self::createLog($user, 'logout', 'User logged out.');
  }

  public static function logFailedLogin($email)
  {
    SecurityLog::create([
      'id_user' => null,
      'type' => 'failed_login',
      'description' => 'Failed login attempt for email: ' . $email,
      'ip_address' => Request::ip(),
      'data' => json_encode([
        'email' => $email,
        'ip' => Request::ip(),
        'user_agent' => Request::header('User-Agent'),
        'url' => Request::fullUrl(),
        'method' => Request::method(),
        'input' => Request::except(['password', 'password_confirmation']),
      ]),
    ]);
  }

  public static function logPasswordChange($user)
  {
    self::createLog($user, 'password_change', 'User changed password.');
  }

  public static function logAccountCreation($user)
  {
    self::createLog($user, 'account_creation', 'User account created.');
  }

  protected static function createLog($user, $type, $description = null, $data = [])
  {
    $requestData = [
      'ip' => Request::ip(),
      'user_agent' => Request::header('User-Agent'),
      'url' => Request::fullUrl(),
      'method' => Request::method(),
      'input' => Request::except(['password', 'password_confirmation']),
    ];

    // Gabungkan $data manual jika ada tambahan
    $mergedData = array_merge($requestData, $data);

    SecurityLog::create([
      'id_user' => $user->id ?? null,
      'type' => $type,
      'description' => $description,
      'ip_address' => Request::ip(),
      'data' => json_encode($mergedData),
    ]);
  }
}