<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DesignFileController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ExternalPurchaseController;

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Customers
    Route::resource('customers', CustomerController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Product Types
    Route::resource('product-types', ProductTypeController::class);

    // Orders
    Route::resource('orders', OrderController::class);
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Design Files
    Route::resource('design-files', DesignFileController::class)->except(['create', 'store']);
    Route::get('/orders/{orderItem}/design-files/create', [DesignFileController::class, 'create'])->name('design-files.create');
    Route::post('/orders/{orderItem}/design-files', [DesignFileController::class, 'store'])->name('design-files.store');
    Route::post('/design-files/{designFile}/approve', [DesignFileController::class, 'approve'])->name('design-files.approve');
    Route::post('/design-files/{designFile}/reject', [DesignFileController::class, 'reject'])->name('design-files.reject');
    Route::get('/design-files/{designFile}/download', [DesignFileController::class, 'download'])->name('design-files.download');

    // Materials
    Route::resource('materials', MaterialController::class);
    Route::post('/materials/{material}/add-stock', [MaterialController::class, 'addStock'])->name('materials.add-stock');
    Route::post('/materials/{material}/use-stock', [MaterialController::class, 'useStock'])->name('materials.use-stock');

    // External Purchases
    Route::resource('external-purchases', ExternalPurchaseController::class);

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    // Route::get('/reports/production', [ReportController::class, 'production'])->name('reports.production');
    // Route::get('/reports/materials', [ReportController::class, 'materials'])->name('reports.materials');
    // Route::get('/reports/profit', [ReportController::class, 'profit'])->name('reports.profit');

    // Settings
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/profile', [\App\Http\Controllers\SettingsController::class, 'updateProfile'])->name('settings.profile.update');
    Route::post('/settings/backup', [\App\Http\Controllers\SettingsController::class, 'backupDatabase'])->name('settings.backup');
});
