<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\ShopProfileController;
use App\Http\Controllers\AdminProfileController;

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

Route::get('/', [HomePageController::class, 'index'])->name('homepage');

Route::get('shop-page', [ShopPageController::class, 'shop_page'])->name('shop-page');
Route::get('/shop/{slug}', [ShopPageController::class, 'shop_details'])->name('shop.details');

Route::get('/product/{slug}', [ShopPageController::class, 'fetchProducts'])->name('api.products');
Route::get('/comment/{shop_id}', [RatingController::class, 'fetchComments'])->name('api.comments');

Route::post('/shop/{slug}/rate', [RatingController::class, 'storeRating'])->name('shop.rate');

Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/ajax/search', [SearchController::class, 'ajaxSearch'])->name('ajax.search');
Route::get('/ajax/product/details', [SearchController::class, 'getProductDetails'])->name('ajax.product.details');

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    Route::middleware(['role:user'])->group(function () {
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/shop-profiles', [ShopProfileController::class, 'index'])->name('shop-profiles.index');
        Route::post('/shop-profiles', [ShopProfileController::class, 'store'])->name('shop-profiles.store');
        Route::put('/shop-profiles/{id}', [ShopProfileController::class, 'update'])->name('shop-profiles.update');
        //post update products
        Route::post('products/update/{id}', [ProductController::class, 'update'])->name('products.newupdate');
        Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
        Route::get('/comment/{shopId}', [RatingController::class, 'fetchCommentsAdmin'])->name('comments.fetch');
        Route::delete('/ratings/delete/{id}', [RatingController::class, 'deleteComment'])->name('ratings.delete');
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);

        Route::get('admin_profiles', [AdminProfileController::class, 'index'])->name('admin_profiles.index');
        Route::post('admin_profiles', [AdminProfileController::class, 'store'])->name('admin_profiles.store');
        Route::put('admin_profiles/{admin_profile}', [AdminProfileController::class, 'update'])->name('admin_profiles.update');
    });
});
