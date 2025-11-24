<?php

use App\Http\Controllers\AccessCredentialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\IndexingTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderIndexingController;
use App\Http\Controllers\WorkTypeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes - Common dashboard
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::put('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
    });

    // routes/web.php
Route::get('/work-orders', [WorkOrderController::class, 'index']);
Route::get('/api/work-orders', [WorkOrderController::class, 'apiWorkOrders']);
Route::get('/api/work-orders/queue-estimations', [WorkOrderController::class, 'getQueueEstimations']);
});

Route::middleware(['auth', 'checkrole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/access-credentials', [AccessCredentialController::class, 'index'])->name('access_credentials.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    Route::resource('indexing-types', IndexingTypeController::class);
    
    Route::resource('users', UserController::class);

    Route::resource('divisions', DivisionController::class);

    Route::resource('work-orders', WorkOrderController::class);

    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work_order_indexing.index');
    
    Route::resource('work-types', WorkTypeController::class);
});

Route::middleware(['auth', 'checkrole:production'])
->prefix('production')
->name('production.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/access-credentials', [AccessCredentialController::class, 'index'])->name('access_credentials.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/indexing-types', [IndexingTypeController::class, 'index'])->name('indexing-types.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work-order-indexing.index');

    Route::resource('work-orders', WorkOrderController::class);

    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
});

Route::middleware(['auth', 'checkrole:sales'])
->prefix('sales')
->name('sales.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/access-credentials', [AccessCredentialController::class, 'index'])->name('access_credentials.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/indexing-types', [IndexingTypeController::class, 'index'])->name('indexing_types.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work_order_indexing.index');
    Route::get('/work-orders', [WorkOrderController::class, 'index'])->name('work-orders.index');
    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
});

Route::middleware(['auth', 'checkrole:asservice'])
->prefix('asservice')
->name('asservice.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('work-orders', WorkOrderController::class);

    Route::get('/access-credentials', [AccessCredentialController::class, 'index'])->name('access_credentials.index');
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/indexing-types', [IndexingTypeController::class, 'index'])->name('indexing-types.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work-order-indexing.index');
    Route::get('/work-orders', [WorkOrderController::class, 'index'])->name('work-orders.index');
    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
});
