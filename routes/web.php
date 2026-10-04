<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SellerOrderController;

Route::get('/api/marketplace/products', [MarketplaceController::class, 'products']);
Route::get('/api/marketplace/categories', [MarketplaceController::class, 'categories']);
Route::post('/api/checkout', [OrderController::class, 'checkout']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Store profile route
    Route::get('/store', [StoreController::class, 'show'])->name('store.show');
    Route::post('/store', [StoreController::class, 'update'])->name('store.update');

    // Product CRUD routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::post('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Seller Orders routes
    Route::get('/seller/orders', [SellerOrderController::class, 'index'])->name('seller.orders.index');
    Route::post('/seller/orders/{order}/status', [SellerOrderController::class, 'updateStatus'])->name('seller.orders.status');
});

require __DIR__.'/auth.php';

Route::get('/{any}', function () { return Inertia::render('Welcome'); })->where('any', '.*');
