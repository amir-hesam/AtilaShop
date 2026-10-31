<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;

/*
|--------------------------------------------------------------------------
| Web Routes - AtilaShop
|--------------------------------------------------------------------------
*/

// صفحات عمومی فروشگاه
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/products/{id}', [ShopController::class, 'show'])->name('products.show');

// مدیریت سبد خرید (مهمان و کاربران وارد شده)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
});

// احراز هویت
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// بخش‌های نیازمند ورود کاربر عادی
Route::middleware('auth')->group(function () {
    // علاقه‌مندی‌ها
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    // ثبت سفارش و تسویه‌حساب
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');

    // سفارش‌های من
    Route::get('/my-orders', [OrderController::class, 'userOrders'])->name('orders.my_orders');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{id}/card-transfer', [OrderController::class, 'cardTransferView'])->name('orders.card_transfer');
    Route::post('/orders/{id}/card-transfer', [OrderController::class, 'submitTrackingCode'])->name('orders.submit_tracking');

    // اعلان‌ها (نوتیفیکیشن‌های کاربر)
    Route::get('/notifications', [OrderController::class, 'getNotifications'])->name('notifications.index');
    Route::post('/notifications/read-all', [OrderController::class, 'markAllNotificationsRead'])->name('notifications.read_all');
    Route::post('/notifications/{id}/read', [OrderController::class, 'markNotificationRead'])->name('notifications.read');

    // شبیه‌ساز درگاه پرداخت آنلاین
    Route::get('/payment/gateway/{order}', [PaymentController::class, 'gateway'])->name('payment.gateway');
    Route::post('/payment/gateway/{order}', [PaymentController::class, 'process'])->name('payment.process');
});

// بخش پنل مدیریت - محافظت‌شده با auth و admin middleware
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // مدیریت محصولات
    Route::resource('products', AdminProductController::class)->except(['show']);

    // مدیریت سفارش‌ها
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');

    // تنظیمات درگاه‌ها و روش‌های پرداخت
    Route::get('/settings', [AdminSettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
