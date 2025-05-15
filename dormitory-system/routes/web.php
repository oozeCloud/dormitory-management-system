<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Tenant\LeaseController;
use App\Http\Controllers\Tenant\ProfileController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Admin\AdminAccountController;
use App\Http\Controllers\Admin\LeaseApprovalController;
use App\Http\Controllers\Admin\AdminDashboardController;

Route::get('/', [AuthController::class, 'showLogin'])->name('tenant.login.show');
Route::post('/login', [AuthController::class, 'login'])->name('tenant.login');
Route::get('/register/show', [AuthController::class, 'showRegister'])->name('tenant.register.show');
Route::post('/register', [AuthController::class, 'register'])->name('tenant.register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:tenant'])->prefix('tenant')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('tenant.profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('tenant.profile.update');

    Route::get('/lease/show', [LeaseController::class, 'showForm'])->name('tenant.lease.show');
    Route::post('/lease/submit', [LeaseController::class, 'submit'])->name('tenant.lease.submit');

    Route::get('/message/admin', [MessageController::class, 'tenantToAdmin'])->name('tenant.message.admin');
    Route::post('/message/send', [MessageController::class, 'tenantMessage'])->name('tenant.message.send');
    Route::get('/tenant/inbox', [MessageController::class, 'tenantInbox'])->name('tenant.inbox');

    Route::get('/payment', [PaymentController::class, 'showPaymentForm'])->name('tenant.payment.form');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('tenant.payment.process');
    Route::get('/payment/history', [PaymentController::class, 'paymentHistory'])->name('tenant.payment.history');
    Route::get('/payment/invoice/{id}', [PaymentController::class, 'showInvoice'])->name('tenant.payment.invoice');

    Route::get('/edit', [LeaseController::class, 'edit'])->name('tenant.lease.edit');
    Route::post('/update', [LeaseController::class, 'updateLease'])->name('tenant.lease.update');

    Route::delete('/delete/{tenant}', [DashboardController::class, 'destroy'])->name('tenant.delete');
});

Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/lease/applications', [LeaseApprovalController::class, 'index'])->name('admin.lease.applications');
    Route::post('/lease/approve/{id}', [LeaseApprovalController::class, 'approve'])->name('admin.lease.approve');
    Route::post('/lease/reject/{id}', [LeaseApprovalController::class, 'reject'])->name('admin.lease.reject');


    Route::get('/message/tenants', [MessageController::class, 'adminToTenants'])->name('admin.message.tenants');
    Route::post('/message/send', [MessageController::class, 'adminMessage'])->name('admin.message.send');
    Route::get('/admin/inbox', [MessageController::class, 'adminInbox'])->name('admin.inbox');

    Route::get('room/', [RoomController::class, 'index'])->name('admin.rooms.index');
    Route::get('room/create', [RoomController::class, 'create'])->name('admin.rooms.create');
    Route::post('room/', [RoomController::class, 'store'])->name('admin.rooms.store');
    Route::get('room/{room}/edit', [RoomController::class, 'edit'])->name('admin.rooms.edit');
    Route::put('room/{room}', [RoomController::class, 'update'])->name('admin.rooms.update');
    Route::delete('room/{room}', [RoomController::class, 'destroy'])->name('admin.rooms.destroy');

    Route::get('tenant/', [TenantController::class, 'index'])->name('admin.tenants.index');
    Route::get('tenant/{tenant}/edit', [TenantController::class, 'edit'])->name('admin.tenants.edit');
    Route::put('tenant/{tenant}', [TenantController::class, 'update'])->name('admin.tenants.update');
    Route::delete('tenant/{tenant}', [TenantController::class, 'destroy'])->name('admin.tenants.delete');

    Route::get('account/edit', [AdminAccountController::class, 'edit'])->name('admin.account.edit');
    Route::post('account/update', [AdminAccountController::class, 'update'])->name('admin.account.update');
    
});
