<?php

use App\Models\Product;
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

