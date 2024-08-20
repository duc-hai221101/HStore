<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;

use App\Models\OrderItem;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home/search', [HomeController::class, 'searchAutocomplete'])->name('products.search');
Route::get('/search', [HomeController::class, 'search'])->name('product.search');
Route::get('/products/{id}', [HomeController::class, 'show'])->name('products.show');

Route::get('/category/{slug}/{id}', [CategoryController::class, 'index'])->name('category.product');

Route::get('/verify-email/{email}', [RegisteredUserController::class, 'verify'])->name('verify-email');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return redirect('/home');
// })->middleware(['auth', 'signed'])->name('verification.verify');

// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
 
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/orders', [OrderController::class, 'userOrders'])->name('profile.orders');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/order/create',[OrderController::class,'create'])->name('order.create');
    Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
    Route::get('/checkout/{order}', [PaymentController::class, 'vnpay'])->name('vnpay');

    Route::post('/vnpay/{orderId}', [PaymentController::class, 'vnpay'])->name('vnpay');
    Route::get('/payment/return/{orderId}', [PaymentController::class, 'handleVNPayReturn'])->name('payment.return');
    Route::get('/vnpay_return', [PaymentController::class, 'vnpayReturn'])->name('vnpay.return');


    Route::get('/order/success/{order}', [OrderController::class, 'success'])->name('order.success');
    Route::post('/cart/update/{itemId}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
    Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{itemId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

});


require __DIR__.'/auth.php';
