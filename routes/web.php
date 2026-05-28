<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', function () {
    return view('home');
});

Route::get('/tentang-kami/ringkasan', [AboutController::class, 'summary'])->name('about.summary');
Route::get('/tentang-kami/visi-misi', [AboutController::class, 'visionMission'])->name('about.vision_mission');

Route::get('/verifikasi-produk', [VerificationController::class, 'index'])->name('verification.index');
Route::post('/verifikasi-produk', [VerificationController::class, 'check'])->name('verification.check');

Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/category/{slug}', [ProductController::class, 'category'])->name('product.category');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');

// Image Fallback
Route::get('/product-images/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) { abort(404); }
    return response()->file($fullPath);
})->where('path', '.*');

// Admin Routes (AdminLTE)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('products/batch-store', [AdminProductController::class, 'batchStore'])->name('products.batch-store');
    Route::get('products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
    Route::patch('products/{product}/quick-update', [AdminProductController::class, 'quickUpdate'])->name('products.quick-update');
    Route::patch('products/{product}/update-image', [AdminProductController::class, 'updateImage'])->name('products.update-image');
    Route::resource('products', AdminProductController::class)->except(['create', 'edit', 'store']);
});
