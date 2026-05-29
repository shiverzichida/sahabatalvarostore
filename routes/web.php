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

// Client Authentication
Route::get('/register', [App\Http\Controllers\Auth\ClientAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\ClientAuthController::class, 'register'])->name('register.submit');
Route::get('/login', [App\Http\Controllers\Auth\ClientAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\ClientAuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [App\Http\Controllers\Auth\ClientAuthController::class, 'logout'])->name('logout');

// Client Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/client/dashboard', [App\Http\Controllers\VitaminPlannerController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/calendar', [App\Http\Controllers\VitaminPlannerController::class, 'calendarPage'])->name('client.calendar');
    Route::get('/client/progress', [App\Http\Controllers\VitaminPlannerController::class, 'progressPage'])->name('client.progress');
    Route::get('/client/request', [App\Http\Controllers\VitaminPlannerController::class, 'requestPage'])->name('client.request');
    Route::post('/client/request', [App\Http\Controllers\VitaminPlannerController::class, 'storeRequest'])->name('client.request.store');
    Route::post('/client/profile', [App\Http\Controllers\VitaminPlannerController::class, 'storeProfile'])->name('client.profile.store');
    Route::post('/client/progress', [App\Http\Controllers\VitaminPlannerController::class, 'storeProgress'])->name('client.progress.store');
});

// Client Vitamin Planner Routes (Public Shared Links)
Route::get('/planner/{code}', [App\Http\Controllers\VitaminPlannerController::class, 'show'])->name('planner.show');
Route::get('/planner/{code}/export', [App\Http\Controllers\VitaminPlannerController::class, 'exportIcs'])->name('planner.export');

// Admin Authentication Routes
Route::get('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login.submit');
Route::post('admin/logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

// Admin Routes (AdminLTE)
Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('products/batch-store', [AdminProductController::class, 'batchStore'])->name('products.batch-store');
    Route::get('products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');
    Route::patch('products/{product}/quick-update', [AdminProductController::class, 'quickUpdate'])->name('products.quick-update');
    Route::patch('products/{product}/update-image', [AdminProductController::class, 'updateImage'])->name('products.update-image');
    Route::resource('products', AdminProductController::class)->except(['create', 'edit', 'store']);
    
    Route::get('planner', [App\Http\Controllers\Admin\VitaminPlannerController::class, 'index'])->name('planner.index');
    Route::post('planner', [App\Http\Controllers\Admin\VitaminPlannerController::class, 'store'])->name('planner.store');
    Route::delete('planner/{planner}', [App\Http\Controllers\Admin\VitaminPlannerController::class, 'destroy'])->name('planner.destroy');
});
