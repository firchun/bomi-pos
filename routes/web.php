<?php

use App\Livewire\Pos;
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
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\IncomeExpenseCategoryController;
use App\Http\Controllers\IncomeExpenseController;
use App\Http\Controllers\IngredientCategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubscriptionController;

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
// languange
Route::post('/change-language', [App\Http\Controllers\LanguageController::class, 'change'])->name('change.language');
Route::middleware(['auth'])->group(function () {

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

        // update pro
        Route::post('/subscription/update-pro/{userId}', [SubscriptionController::class, 'updatePro'])->name('subscription.updatePro');
        // calendar
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        // product
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        // ingredient
        Route::get('/ingredient', [IngredientController::class, 'index'])->name('ingredient');
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

        Route::get('/chat', [ChatController::class, 'userChat'])->name('user.chat');
        Route::post('/message/send-user', [ChatController::class, 'sendMessageUser'])->name('message.sendUser');
        Route::get('/user', [ChatController::class, 'userDashboard'])->name('user.dashboard');
        Route::post('/user/get-messages', [ChatController::class, 'getUserMessages'])->name('user.getMessages');
        Route::post('/user/send-message', [ChatController::class, 'sendMessageToAdmin'])->name('user.sendMessage');

        Route::get('/home-pos', Pos::class)->name('user.pos');

        Route::get('/daily-report', [ReportController::class, 'dailyReport'])->name('daily.report');
        Route::get('/daily-report-datatable', [ReportController::class, 'dailyReportDatatable'])->name('daily-report-datatable');
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
        // subscription
        Route::get('/admin/subscriptions', [SubscriptionController::class, 'index'])->name('subscription.index');
        Route::post('/admin/subscriptions/update', [SubscriptionController::class, 'update'])->name('subscription.update');
    });
});
