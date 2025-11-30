<?php

use App\Http\Controllers\AccessCredentialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\IndexingTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkOrderController;
use App\Http\Controllers\WorkOrderIndexingController;
use App\Http\Controllers\WorkTypeController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('queue.index');
});

Route::get('/queue', [QueueController::class, 'index'])->name('queue.index');
Route::post('/queue/check', [QueueController::class, 'checkStatus'])->name('queue.check');

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

    // Queue routes
    Route::get('/api/queue', [QueueController::class, 'getQueueData'])->name('api.queue.data');
});

Route::middleware(['auth', 'checkrole:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('customers', CustomerController::class);

    Route::resource('indexing-types', IndexingTypeController::class);
    
    Route::resource('users', UserController::class);

    Route::resource('divisions', DivisionController::class);

    Route::resource('work-orders', WorkOrderController::class);
    
    // Status-based work order views
    Route::get('/work-orders/status/validate', [WorkOrderController::class, 'showValidate'])->name('work-orders.status.validate');
    Route::get('/work-orders/status/queue', [WorkOrderController::class, 'showQueue'])->name('work-orders.status.queue');
    Route::get('/work-orders/status/pending', [WorkOrderController::class, 'showPending'])->name('work-orders.status.pending');
    Route::get('/work-orders/status/progress', [WorkOrderController::class, 'showProgress'])->name('work-orders.status.progress');
    Route::get('/work-orders/status/revision', [WorkOrderController::class, 'showRevision'])->name('work-orders.status.revision');
    Route::get('/work-orders/status/migration', [WorkOrderController::class, 'showMigration'])->name('work-orders.status.migration');
    Route::get('/work-orders/status/finish', [WorkOrderController::class, 'showFinish'])->name('work-orders.status.finish');

    Route::resource('access-credentials', AccessCredentialController::class);
    
    // Access Credentials Routes for Admin
    Route::post('/work-orders/{workOrder}/send-access', [AccessCredentialController::class, 'updateSendAccess'])->name('work-orders.send-access');
    Route::get('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData'])->name('work-orders.email-data');
    Route::post('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData']); // For password verification

    Route::resource('work-order-indexing', WorkOrderIndexingController::class);
    
    Route::resource('work-types', WorkTypeController::class);
});

Route::middleware(['auth', 'checkrole:production'])
->prefix('production')
->name('production.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('access-credentials', AccessCredentialController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/indexing-types', [IndexingTypeController::class, 'index'])->name('indexing-types.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work-order-indexing.index');

    Route::resource('work-orders', WorkOrderController::class);
    Route::post('/work-orders/{workOrder}/status', [WorkOrderController::class, 'updateStatus'])->name('work-orders.updateStatus');
    
    // Status-based work order views
    Route::get('/work-orders/status/validate', [WorkOrderController::class, 'showValidate'])->name('work-orders.status.validate');
    Route::get('/work-orders/status/queue', [WorkOrderController::class, 'showQueue'])->name('work-orders.status.queue');
    Route::get('/work-orders/status/pending', [WorkOrderController::class, 'showPending'])->name('work-orders.status.pending');
    Route::get('/work-orders/status/progress', [WorkOrderController::class, 'showProgress'])->name('work-orders.status.progress');
    Route::get('/work-orders/status/revision', [WorkOrderController::class, 'showRevision'])->name('work-orders.status.revision');
    Route::get('/work-orders/status/migration', [WorkOrderController::class, 'showMigration'])->name('work-orders.status.migration');
    Route::get('/work-orders/status/finish', [WorkOrderController::class, 'showFinish'])->name('work-orders.status.finish');
    
    // Access Credentials Routes for Production
    Route::post('/work-orders/{workOrder}/send-access', [AccessCredentialController::class, 'updateSendAccess'])->name('work-orders.send-access');
    Route::get('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData'])->name('work-orders.email-data');
    Route::post('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData']); // For password verification

    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
});

Route::middleware(['auth', 'checkrole:sales'])
->prefix('sales')
->name('sales.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('access-credentials', AccessCredentialController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/indexing-types', [IndexingTypeController::class, 'index'])->name('indexing-types.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work-order-indexing.index');

    Route::resource('work-orders', WorkOrderController::class);
    
    // Status-based work order views
    Route::get('/work-orders/status/validate', [WorkOrderController::class, 'showValidate'])->name('work-orders.status.validate');
    Route::get('/work-orders/status/queue', [WorkOrderController::class, 'showQueue'])->name('work-orders.status.queue');
    Route::get('/work-orders/status/pending', [WorkOrderController::class, 'showPending'])->name('work-orders.status.pending');
    Route::get('/work-orders/status/progress', [WorkOrderController::class, 'showProgress'])->name('work-orders.status.progress');
    Route::get('/work-orders/status/revision', [WorkOrderController::class, 'showRevision'])->name('work-orders.status.revision');
    Route::get('/work-orders/status/migration', [WorkOrderController::class, 'showMigration'])->name('work-orders.status.migration');
    Route::get('/work-orders/status/finish', [WorkOrderController::class, 'showFinish'])->name('work-orders.status.finish');
    
    // Access Credentials Routes for Sales
    Route::post('/work-orders/{workOrder}/send-access', [AccessCredentialController::class, 'updateSendAccess'])->name('work-orders.send-access');
    Route::get('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData'])->name('work-orders.email-data');
    Route::post('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData']); // For password verification
    
    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
});

Route::middleware(['auth', 'checkrole:asservice'])
->prefix('asservice')
->name('asservice.')
->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('work-orders', WorkOrderController::class);
    Route::resource('work-order-indexing', WorkOrderIndexingController::class);
    
    // Status-based work order views
    Route::get('/work-orders/status/validate', [WorkOrderController::class, 'showValidate'])->name('work-orders.status.validate');
    Route::get('/work-orders/status/queue', [WorkOrderController::class, 'showQueue'])->name('work-orders.status.queue');
    Route::get('/work-orders/status/pending', [WorkOrderController::class, 'showPending'])->name('work-orders.status.pending');
    Route::get('/work-orders/status/progress', [WorkOrderController::class, 'showProgress'])->name('work-orders.status.progress');
    Route::get('/work-orders/status/revision', [WorkOrderController::class, 'showRevision'])->name('work-orders.status.revision');
    Route::get('/work-orders/status/migration', [WorkOrderController::class, 'showMigration'])->name('work-orders.status.migration');
    Route::get('/work-orders/status/finish', [WorkOrderController::class, 'showFinish'])->name('work-orders.status.finish');

    // Access Credentials Routes for AsService
    Route::post('/work-orders/{workOrder}/send-access', [AccessCredentialController::class, 'updateSendAccess'])->name('work-orders.send-access');
    Route::get('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData'])->name('work-orders.email-data');
    Route::post('/work-orders/{workOrder}/email-data', [AccessCredentialController::class, 'getEmailData']); // For password verification

    Route::resource('access-credentials', AccessCredentialController::class);
    Route::resource('customers', CustomerController::class);
    Route::get('/divisions', [DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/indexing-types', [IndexingTypeController::class, 'index'])->name('indexing-types.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/work-order-indexing', [WorkOrderIndexingController::class, 'index'])->name('work-order-indexing.index');
    Route::get('/work-types', [WorkTypeController::class, 'index'])->name('work-types.index');
});