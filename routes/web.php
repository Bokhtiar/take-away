<?php

use App\Models\Product;
use App\Models\Chef;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $headChef = Chef::query()
        ->orderByRaw("CASE
            WHEN designation LIKE '%Executive%' THEN 1
            WHEN designation LIKE '%Head%' THEN 2
            ELSE 3
        END")
        ->latest()
        ->first();

    $juniorChefs = Chef::query()
        ->when($headChef?->id, fn ($q) => $q->where('id', '!=', $headChef->id))
        ->latest()
        ->limit(3)
        ->get();

    $products = Product::with([
        'category:id,name',
        'productIngredients.ingredient:id,name,unit',
        'productAddons.addon:id,name,price',
    ])
        ->where('is_available', true)
        ->latest()
        ->paginate(9)
        ->withQueryString();

    return view('welcome', compact('products', 'headChef', 'juniorChefs'));
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

