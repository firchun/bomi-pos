<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer('*', function ($view) {
            $setting = null;
            if (Auth::check()) {
                $setting = Setting::where('id_user', Auth::id())->latest()->first();
            }
            $view->with('setting', $setting);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFour();
        App::setLocale(Session::get('locale', 'id'));
    }
}
