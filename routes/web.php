<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    Route::middleware(['role:user,staff'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        //post update products
        Route::post('products/update/{id}', [ProductController::class, 'update'])->name('products.newupdate');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});
