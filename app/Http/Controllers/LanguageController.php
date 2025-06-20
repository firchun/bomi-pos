<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request)
    {
        $lang = $request->language ?? 'id';
        Session::put('locale', $lang);
        App::setLocale($lang);

        return back();
    }
}
