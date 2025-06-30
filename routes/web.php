<?php

use App\Livewire\Pos;
use App\Livewire\Payment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QRCodeController;
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
use App\Http\Controllers\AdsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\IncomeExpenseCategoryController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\IngredientCategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocalServerTokenController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PackageAccountController;
use App\Http\Controllers\PackageDeviceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SyncController;
use App\Http\Controllers\TablesController;
use App\Models\PackageDevice;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

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
// homepage
Route::get('/', [HomePageController::class, 'index'])
    ->middleware('local.redirect')
    ->name('homepage');
Route::get('shop-page', [HomePageController::class, 'outlet'])
    ->middleware('local.to.online')
    ->name('shop-page');
Route::get('/shop/{slug}', [HomePageController::class, 'outlet_details'])
    ->middleware('local.to.online')->name('shop.details');

Route::get('/shop/table/{code}', [HomePageController::class, 'order_table'])
    ->middleware('local.to.online')
    ->name('shop.table');

Route::get('bomi-products', [HomePageController::class, 'bomiProduct'])
    ->middleware('local.to.online')
    ->name('bomi-products.home');
Route::get('bisnis/fb', [HomePageController::class, 'bisnisFb'])
    ->middleware('local.to.online')
    ->name('bisnis.fb');
Route::get('bisnis/jasa', [HomePageController::class, 'bisnisJasa'])
    ->middleware('local.to.online')
    ->name('bisnis.jasa');
Route::get('bisnis/retail', [HomePageController::class, 'bisnisRetail'])
    ->middleware('local.to.online')
    ->name('bisnis.retail');
Route::get('blogs', [HomePageController::class, 'blog'])
    ->middleware('local.to.online')
    ->name('blogs');
Route::get('blogs/{slug}', [HomePageController::class, 'blogDetail'])
    ->middleware('local.to.online')
    ->name('blog-detail');


// end homepage
// check network
Route::get('/check-network', function () {
    return response()->json([
        'online' => \App\Helpers\Network::isOnline(),
    ]);
});
// singkronisasi data
Route::post('/api/upload-users', [SyncController::class, 'uploadUsers']);
Route::get('/api/download-users', [SyncController::class, 'downloadUsers']);
Route::get('/sync-users', [SyncController::class, 'syncUsersWithCloud']); // Di sisi lokal

// Route::get('shop-page', [ShopPageController::class, 'shop_page'])->name('shop-page');
// Route::get('/shop/{slug}', [ShopPageController::class, 'shop_details'])->name('shop.details');
// Route::get('bomi-products', [AdminProductController::class, 'home'])->name('bomi-products.home');
// Route::get('bomi-products/fetch', [AdminProductController::class, 'fetchProducts'])->name('api.adminproducts');

Route::get('/product/{slug}', [ShopPageController::class, 'fetchProducts'])->name('api.products');
Route::get('/product-cat/{slug}', [ShopPageController::class, 'fetchCategoryProducts'])->name('api.product-cat');
Route::get('/comment/{shop_id}', [RatingController::class, 'fetchComments'])->name('api.comments');

Route::post('/shop/{slug}/rate', [RatingController::class, 'storeRating'])->name('shop.rate');

// Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search', [SearchController::class, 'index']);
Route::get('/search-blog', [SearchController::class, 'blog']);
Route::get('/ajax/search', [SearchController::class, 'ajaxSearch'])->name('ajax.search');
Route::get('/ajax/search-blog', [SearchController::class, 'ajaxSearchBlog'])->name('ajax.search-blog');
Route::get('/ajax/product/details', [SearchController::class, 'getProductDetails'])->name('ajax.product.details');
// autenticated
Route::get('/login', [HomeController::class, 'login'])->name('login');
Route::get('/register', [HomeController::class, 'register'])->name('register');
// password
Route::get('/forgot-password', [HomeController::class, 'createForgot'])->name('password.request');
Route::post('/forgot-password', [HomeController::class, 'storeForgot'])->name('password.email');
Route::get('/reset-password/{token}', [HomeController::class, 'createReset'])->name('password.reset');
Route::post('/reset-password', [HomeController::class, 'storeReset'])->name('password.update');
// email
// Tampilkan halaman verifikasi email
Route::get('/email/verify', function () {
    if (Auth::user()?->hasVerifiedEmail()) {
        return redirect()->intended('/dashboard');
    }
    return view('pages.auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

// Verifikasi email saat klik link
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // ganti sesuai halaman setelah verifikasi
})->middleware(['auth', 'signed'])->name('verification.verify');
// Kirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
// languange
Route::post('/change-language', [LanguageController::class, 'change'])->name('change.language');
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard-data', [HomeController::class, 'getDashboardData'])->name('dashboard.data');
    Route::get('/dashboard/reviews', [HomeController::class, 'getReviews'])->name('dashboard.reviews');
    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    // notification
    Route::get('data-notification', [NotificationController::class, 'getNotifications'])->name('data-notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    // profile
    // subscribtion
    Route::get('/subscribe', [SubscriptionController::class, 'index'])->name('subscribe');
    Route::post('/subscribe', [SubscriptionController::class, 'store']);
    Route::put('profile/update/{id}', [UserController::class, 'update'])->name('profile.update');
    Route::middleware(['role:user'])->group(function () {
        if (App::environment() !== 'local') {
            // token server
            Route::get('/local-server', [LocalServerTokenController::class, 'index'])->name('local-server.index');
            Route::post('/generate-token', [LocalServerTokenController::class, 'generate'])->name('generate-token');
        }
        // setting
        // Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::match(['get', 'post'], '/settings', [SettingController::class, 'index'])->name('settings.index');
        // update pro
        Route::post('/subscription/update-pro/{userId}', [SubscriptionController::class, 'updatePro'])->name('subscription.updatePro');
        // calendar
        Route::resource('tables', TablesController::class);
        Route::get('/table/print', [TablesController::class, 'print'])->name('tables.print');
        // calendar
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        // advertisement
        Route::resource('advertisement', AdsController::class);

        // product
        Route::resource('products', ProductController::class);
        Route::post('/products/update-discount', [ProductController::class, 'updateDiscount'])->name('products.updateDiscount');
        Route::get('products/ingredient/{id}', [ProductController::class, 'ingredient'])->name('products.ingredient');
        // ingredients
        Route::post('/ingredient-dish/store', [IngredientController::class, 'storeDish'])->name('ingredient-dish.store');
        Route::delete('/ingredient-dish/destroy/{id}', [IngredientController::class, 'destroyDish'])->name('ingredient-dish.destroy');
        Route::resource('categories', CategoryController::class);
        // ingredient
        Route::resource('ingredient', IngredientController::class);
        // ingredient category
        Route::get('/ingredient-category', [IngredientCategoryController::class, 'index'])->name('ingredient-category');
        Route::post('/ingredient-category/store', [IngredientCategoryController::class, 'store'])->name('ingredient-category.store');
        Route::delete('/ingredient-category/delete/{id}', [IngredientCategoryController::class, 'destroy'])->name('ingredient-category.delete');
        Route::put('/ingredient-category/update/{id}', [IngredientCategoryController::class, 'update'])->name('ingredient-category.update');
        // profiles
        Route::get('/shop-profiles', [ShopProfileController::class, 'index'])->name('shop-profiles.index');
        Route::post('/shop-profiles', [ShopProfileController::class, 'store'])->name('shop-profiles.store');
        Route::put('/shop-profiles/{id}', [ShopProfileController::class, 'update'])->name('shop-profiles.update');

        //post update products
        Route::post('products/update/{id}', [ProductController::class, 'update'])->name('products.newupdate');
        Route::get('/ratings', [RatingController::class, 'index'])->name('ratings.index');
        Route::get('/comment/{shopId}', [RatingController::class, 'fetchCommentsAdmin'])->name('comments.fetch');
        Route::delete('/ratings/delete/{id}', [RatingController::class, 'deleteComment'])->name('ratings.delete');
        if (App::environment() !== 'local') {
            Route::get('/chat', [ChatController::class, 'userChat'])->name('user.chat');
            Route::post('/message/send-user', [ChatController::class, 'sendMessageUser'])->name('message.sendUser');
            Route::get('/user', [ChatController::class, 'userDashboard'])->name('user.dashboard');
            Route::post('/user/get-messages', [ChatController::class, 'getUserMessages'])->name('user.getMessages');
            Route::post('/user/send-message', [ChatController::class, 'sendMessageToAdmin'])->name('user.sendMessage');
        }
        Route::get('/home-pos', Pos::class)->name('user.pos');
        Route::get('/payment', Payment::class)->name('user.payment');

        Route::get('/ingredient-report', [ReportController::class, 'ingredientReport'])->name('ingredient.report');
        Route::get('/daily-report', [ReportController::class, 'dailyReport'])->name('daily.report');
        Route::get('/product-report', [ReportController::class, 'productReport'])->name('product.report');
        Route::get('/ingredient-report-datatable', [ReportController::class, 'ingredientReportDatatable'])->name('ingredient-report-datatable');
        Route::get('/daily-report-datatable', [ReportController::class, 'dailyReportDatatable'])->name('daily-report-datatable');
        Route::get('/product-report-datatable', [ReportController::class, 'productReportDatatable'])->name('product-report-datatable');
        Route::get('/reports/{order}', [ReportController::class, 'show'])->name('report.show');
        Route::get('/report/{id}/printTransaction', [ReportController::class, 'printTransaction'])->name('report.printTransaction');

        Route::get('/dashboard/transaction-data', [HomeController::class, 'getTransactionData']);
        Route::get('/dashboard/sales-statistics', [HomeController::class, 'getSalesStatistics']);

        Route::post('/generate-qrcode-pdf', [QRCodeController::class, 'generatePDF'])->name('qr.generate.pdf');
        //finance for subscribtion
        Route::middleware(['check.subscription'])->group(function () {
            // finance category
            Route::get('/financial/category', [IncomeExpenseCategoryController::class, 'index'])->name('financial.category');
            Route::post('/financial/category-store', [IncomeExpenseCategoryController::class, 'store'])->name('financial.category-store');
            Route::delete('/financial/category-destroy/{id}', [IncomeExpenseCategoryController::class, 'destroy'])->name('financial.category-destroy');
            Route::put('/financial/category/{id}/update', [IncomeExpenseCategoryController::class, 'update'])->name('financial.category-update');
            // finance income
            Route::get('/financial/income', [IncomeExpenseController::class, 'income'])->name('financial.income');
            Route::get('/financial/income-expense-store', [IncomeExpenseController::class, 'store'])->name('financial.income-expense-store');
            // finance expenses
            Route::get('/financial/expenses', [IncomeExpenseController::class, 'expenses'])->name('financial.expenses');
        });
    });
    if (App::environment() !== 'local') {
        Route::middleware(['role:admin'])->group(function () {
            Route::get('users/admin', [UserController::class, 'admin'])->name('users.admin');
            Route::resource('users', UserController::class);

            Route::prefix('admin-products')->name('admin-products.')->group(function () {
                Route::get('/', [AdminProductController::class, 'index'])->name('index');
                Route::get('/create', [AdminProductController::class, 'create'])->name('create');
                Route::post('/', [AdminProductController::class, 'store'])->name('store');
                Route::get('/{adminproduct}/edit', [AdminProductController::class, 'edit'])->name('edit');
                Route::put('/{adminproduct}', [AdminProductController::class, 'update'])->name('update');
                Route::delete('/{adminproduct}', [AdminProductController::class, 'destroy'])->name('destroy');
            });
            // blogs
            Route::resource('admin-blogs', BlogController::class);
            // package device bomi
            Route::resource('packages-device', PackageDeviceController::class);
            // package account bomi
            Route::resource('packages-account', PackageAccountController::class);
            //admin profile
            Route::get('admin_profiles', [AdminProfileController::class, 'index'])->name('admin_profiles.index');
            Route::post('admin_profiles', [AdminProfileController::class, 'store'])->name('admin_profiles.store');
            Route::put('admin_profiles/{admin_profile}', [AdminProfileController::class, 'update'])->name('admin_profiles.update');

            Route::get('/admin/dashboard', [ChatController::class, 'adminDashboard'])->name('admin.dashboard');
            Route::get('/admin/get-users', [ChatController::class, 'getUserList'])->name('admin.getUserList');
            Route::post('/admin/get-messages', [ChatController::class, 'getAdminMessages'])->name('admin.getMessages');
            Route::post('/admin/send-message', [ChatController::class, 'sendMessageToUser'])->name('admin.sendMessage');
            Route::get('/admin/get-unread-counts', [ChatController::class, 'getUnreadCounts'])->name('admin.getUnreadCounts');
            // subscription
            Route::get('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
            Route::post('/admin/subscriptions/update', [SubscriptionController::class, 'update'])->name('subscription.update');
        });
    }
});
