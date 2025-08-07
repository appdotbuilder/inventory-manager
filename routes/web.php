<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

Route::get('/', function () {
    return Inertia::render('welcome', [
        'auth' => [
            'user' => auth()->user(),
        ],
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    // Product management
    Route::resource('products', App\Http\Controllers\ProductController::class);
    
    // Category management
    Route::resource('categories', App\Http\Controllers\CategoryController::class);
    
    // Supplier management
    Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
    
    // Stock movements
    Route::get('stock-movements', [App\Http\Controllers\StockMovementController::class, 'index'])->name('stock-movements.index');
    Route::post('stock-movements', [App\Http\Controllers\StockMovementController::class, 'store'])->name('stock-movements.store');
    
    // Outgoing requests
    Route::resource('outgoing-requests', App\Http\Controllers\OutgoingRequestController::class);
    
    // Returns
    Route::resource('returns', App\Http\Controllers\ReturnsController::class);
    
    // Repairs
    Route::resource('repairs', App\Http\Controllers\RepairController::class);
    
    // Reports
    Route::resource('reports', App\Http\Controllers\ReportController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
