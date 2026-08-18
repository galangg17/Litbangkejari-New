<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Public Portal Landing Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::post('/submit-proposal', [LandingController::class, 'submitProposal'])->name('landing.submit_proposal');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Admin Routes
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('/dashboard/store-kajian', [DashboardController::class, 'storeKajian'])->name('dashboard.store_kajian');
    Route::post('/dashboard/disposition/{id}', [DashboardController::class, 'disposition'])->name('dashboard.disposition');
    Route::post('/dashboard/update-review/{id}', [DashboardController::class, 'updateReview'])->name('dashboard.update_review');
    
    // Settings & Category CRUD Routes
    Route::post('/dashboard/store-category', [DashboardController::class, 'storeCategory'])->name('dashboard.store_category');
    Route::delete('/dashboard/delete-category/{id}', [DashboardController::class, 'destroyCategory'])->name('dashboard.destroy_category');
    Route::post('/dashboard/reset-data', [DashboardController::class, 'resetData'])->name('dashboard.reset_data');
    Route::post('/dashboard/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.update_settings');

    // User Management Routes
    Route::post('/dashboard/users/store', [DashboardController::class, 'storeUser'])->name('dashboard.users.store');
    Route::post('/dashboard/users/update/{id}', [DashboardController::class, 'updateUser'])->name('dashboard.users.update');
    Route::delete('/dashboard/users/delete/{id}', [DashboardController::class, 'destroyUser'])->name('dashboard.users.destroy');
});
