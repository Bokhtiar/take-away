<?php

use App\Models\Product;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::with([
        'category:id,name',
        'productIngredients.ingredient:id,name,unit',
        'productAddons.addon:id,name,price',
    ])
        ->where('is_available', true)
        ->latest()
        ->get();

    return view('welcome', compact('products'));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [UserAuthController::class, 'showLoginForm'])->name('user.login');
    Route::post('/login', [UserAuthController::class, 'login'])->name('user.login.submit');
    Route::get('/register', [UserAuthController::class, 'showRegisterForm'])->name('user.register');
    Route::post('/register', [UserAuthController::class, 'register'])->name('user.register.submit');
});

Route::post('/logout', [UserAuthController::class, 'logout'])
    ->middleware('auth')
    ->name('user.logout');

Route::middleware('auth')->group(function () {
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

