<?php

use App\Livewire\Pos;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\ShopPageController;
use App\Http\Controllers\ShopProfileController;
use App\Http\Controllers\AdminProductController;
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

Route::get('bomi-products', [AdminProductController::class, 'home'])->name('bomi-products.home');
Route::get('bomi-products/fetch', [AdminProductController::class, 'fetchProducts'])->name('api.adminproducts');

Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    Route::put('profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
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

        Route::get('/chat', [ChatController::class, 'userChat'])->name('user.chat');
        Route::post('/message/send-user', [ChatController::class, 'sendMessageUser'])->name('message.sendUser');
        Route::get('/user', [ChatController::class, 'userDashboard'])->name('user.dashboard');
        Route::post('/user/get-messages', [ChatController::class, 'getUserMessages'])->name('user.getMessages');
        Route::post('/user/send-message', [ChatController::class, 'sendMessageToAdmin'])->name('user.sendMessage');

        Route::get('/home-pos', Pos::class)->name('user.pos');

        Route::get('/daily-report', [ReportController::class, 'dailyReport'])->name('daily.report');
        Route::get('/reports/{order}', [ReportController::class, 'show'])->name('report.show');
        Route::get('/report/{id}/printTransaction', [ReportController::class, 'printTransaction'])->name('report.printTransaction');

        Route::get('/dashboard/transaction-data', [HomeController::class, 'getTransactionData']);
        Route::get('/dashboard/sales-statistics', [HomeController::class, 'getSalesStatistics']);
    });
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);

        Route::prefix('admin-products')->name('admin-products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::get('/create', [AdminProductController::class, 'create'])->name('create'); 
            Route::post('/', [AdminProductController::class, 'store'])->name('store');
            Route::get('/{adminproduct}/edit', [AdminProductController::class, 'edit'])->name('edit');
            Route::put('/{adminproduct}', [AdminProductController::class, 'update'])->name('update'); 
            Route::delete('/{adminproduct}', [AdminProductController::class, 'destroy'])->name('destroy');
        });

        Route::get('admin_profiles', [AdminProfileController::class, 'index'])->name('admin_profiles.index');
        Route::post('admin_profiles', [AdminProfileController::class, 'store'])->name('admin_profiles.store');
        Route::put('admin_profiles/{admin_profile}', [AdminProfileController::class, 'update'])->name('admin_profiles.update');

        Route::get('/admin/dashboard', [ChatController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/get-users', [ChatController::class, 'getUserList'])->name('admin.getUserList');
        Route::post('/admin/get-messages', [ChatController::class, 'getAdminMessages'])->name('admin.getMessages');
        Route::post('/admin/send-message', [ChatController::class, 'sendMessageToUser'])->name('admin.sendMessage');
        Route::get('/admin/get-unread-counts', [ChatController::class, 'getUnreadCounts'])->name('admin.getUnreadCounts');
    });
});
