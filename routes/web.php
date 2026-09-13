<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Public Portal Landing Routes
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::post('/submit-proposal', [LandingController::class, 'submitProposal'])->name('landing.submit_proposal');
Route::post('/upload-curriculum', [LandingController::class, 'uploadCurriculum'])->name('landing.curriculums.upload');
Route::get('/catalog/download/{type}/{id}', [LandingController::class, 'downloadDocument'])->name('catalog.download');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Admin Routes
Route::middleware(['web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/export/proposals', [DashboardController::class, 'exportProposalsCsv'])->name('dashboard.export.csv');
    Route::post('/dashboard/store-kajian', [DashboardController::class, 'storeKajian'])->name('dashboard.store_kajian');
    Route::post('/dashboard/disposition/{id}', [DashboardController::class, 'disposition'])->name('dashboard.disposition');
    Route::post('/dashboard/policy/update/{id}', [DashboardController::class, 'updateKajian'])->name('dashboard.policy.update');
    Route::delete('/dashboard/policy/delete/{id}', [DashboardController::class, 'destroyKajian'])->name('dashboard.policy.destroy');
    Route::post('/dashboard/policy/toggle-publish/{id}', [DashboardController::class, 'toggleKajianPublish'])->name('dashboard.policy.toggle_publish');
    
    // Passcode PIN & Form Builder Routes
    Route::post('/dashboard/update-pin', [DashboardController::class, 'updatePinPasscode'])->name('dashboard.update_pin');
    Route::post('/dashboard/form-fields/store', [DashboardController::class, 'storeFormField'])->name('dashboard.form_fields.store');
    Route::delete('/dashboard/form-fields/delete/{id}', [DashboardController::class, 'destroyFormField'])->name('dashboard.form_fields.destroy');

    // Pilar 2: Innovations Routes
    Route::post('/dashboard/innovations/store', [DashboardController::class, 'storeInnovation'])->name('dashboard.innovations.store');
    Route::post('/dashboard/innovations/update/{id}', [DashboardController::class, 'updateInnovation'])->name('dashboard.innovations.update');
    Route::delete('/dashboard/innovations/delete/{id}', [DashboardController::class, 'destroyInnovation'])->name('dashboard.innovations.destroy');
    Route::post('/dashboard/innovations/toggle-publish/{id}', [DashboardController::class, 'toggleInnovationPublish'])->name('dashboard.innovations.toggle_publish');

    // Pilar 3: Curriculums Routes
    Route::post('/dashboard/curriculums/store', [DashboardController::class, 'storeCurriculum'])->name('dashboard.curriculums.store');
    Route::post('/dashboard/curriculums/update/{id}', [DashboardController::class, 'updateCurriculum'])->name('dashboard.curriculums.update');
    Route::post('/dashboard/curriculums/verify/{id}', [DashboardController::class, 'verifyCurriculum'])->name('dashboard.curriculums.verify');
    Route::post('/dashboard/curriculums/toggle-publish/{id}', [DashboardController::class, 'toggleCurriculumVerify'])->name('dashboard.curriculums.toggle_publish');
    Route::delete('/dashboard/curriculums/delete/{id}', [DashboardController::class, 'destroyCurriculum'])->name('dashboard.curriculums.destroy');

    // Settings & Category CRUD Routes
    Route::post('/dashboard/store-category', [DashboardController::class, 'storeCategory'])->name('dashboard.store_category');
    Route::delete('/dashboard/delete-category/{id}', [DashboardController::class, 'destroyCategory'])->name('dashboard.destroy_category');
    Route::post('/dashboard/settings', [DashboardController::class, 'updateSettings'])->name('dashboard.update_settings');
    Route::post('/dashboard/reset-testing-data', [DashboardController::class, 'resetTestingData'])->name('dashboard.reset_testing_data');

    // User Management Routes
    Route::post('/dashboard/users/store', [DashboardController::class, 'storeUser'])->name('dashboard.users.store');
    Route::post('/dashboard/users/update/{id}', [DashboardController::class, 'updateUser'])->name('dashboard.users.update');
    Route::delete('/dashboard/users/delete/{id}', [DashboardController::class, 'destroyUser'])->name('dashboard.users.destroy');
});
