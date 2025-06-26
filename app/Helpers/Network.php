<?php

namespace App\Helpers;

class Network
{
  public static function isOnline()
  {
    // Coba ping Google (bisa diganti domain lain)
    try {
      $connected = @fsockopen("www.google.com", 80);
      return $connected ? true : false;
    } catch (\Exception $e) {
      return false;
    }
  }
}
