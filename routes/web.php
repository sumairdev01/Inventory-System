<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\ReturnController;
use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Resources
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('sales', SaleController::class); 

    // Invoices
    Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');

    // Stock Management
    Route::get('/stock/{product}/create', [StockTransactionController::class, 'create'])->name('stock.create');
    Route::post('/stock', [StockTransactionController::class, 'store'])->name('stock.store');
    Route::get('/stock/history', [StockTransactionController::class, 'historyIndex'])->name('stock.history.index');
    Route::get('/stock/{product}/history', [StockTransactionController::class, 'history'])->name('stock.history');
    // Returns & Refunds
    Route::get('/returns/sales', [ReturnController::class, 'salesIndex'])->name('returns.sales.index');
    Route::get('/returns/sales/{sale}/create', [ReturnController::class, 'createSaleReturn'])->name('returns.sales.create');
    Route::post('/returns/sales/{sale}', [ReturnController::class, 'storeSaleReturn'])->name('returns.sales.store');

    Route::get('/returns/purchases', [ReturnController::class, 'purchasesIndex'])->name('returns.purchases.index');
    Route::get('/returns/purchases/{purchase}/create', [ReturnController::class, 'createPurchaseReturn'])->name('returns.purchases.create');
    Route::post('/returns/purchases/{purchase}', [ReturnController::class, 'storePurchaseReturn'])->name('returns.purchases.store');
});

require __DIR__.'/auth.php';
