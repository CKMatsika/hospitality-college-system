<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CPDController;

/*
|--------------------------------------------------------------------------
| CPD Routes
|--------------------------------------------------------------------------
|
| Routes for Continuing Professional Development system
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // CPD Dashboard
    Route::get('/cpd', [CPDController::class, 'dashboard'])->name('cpd.dashboard');
    
    // CPD History
    Route::get('/cpd/history', [CPDController::class, 'history'])->name('cpd.history');
    
    // CPD Level Progress
    Route::get('/cpd/progress', [CPDController::class, 'levelProgress'])->name('cpd.progress');
    
    // CPD Analytics
    Route::get('/cpd/analytics', [CPDController::class, 'analytics'])->name('cpd.analytics');
    
    // External Training
    Route::get('/cpd/external-training', [CPDController::class, 'externalTraining'])->name('cpd.external-training');
    Route::post('/cpd/external-training', [CPDController::class, 'submitExternalTraining'])->name('cpd.external-training.submit');
    
    // CPD Certificates
    Route::get('/cpd/certificates', [CPDController::class, 'certificates'])->name('cpd.certificates');
    Route::get('/cpd/generate-certificate', [CPDController::class, 'generateCertificate'])->name('cpd.generate-certificate');
    Route::post('/cpd/generate-certificate', [CPDController::class, 'processCertificate'])->name('cpd.generate-certificate.process');
    
    // Certificate Actions
    Route::get('/certificates/{certificate}/download', [CPDController::class, 'downloadCertificate'])->name('certificates.download');
    Route::get('/certificates/{certificate}/show', [CPDController::class, 'showCertificate'])->name('certificates.show');
    
    // CPD Verification
    Route::get('/cpd/verify', [CPDController::class, 'verifyCertificate'])->name('cpd.verify');
    
    // Admin Routes
    Route::middleware(['role:admin,super_admin'])->group(function () {
        Route::get('/admin/cpd', [CPDController::class, 'adminIndex'])->name('cpd.admin.index');
        Route::post('/admin/cpd/{record}/approve', [CPDController::class, 'approveRecord'])->name('cpd.admin.approve');
        Route::post('/admin/cpd/{record}/reject', [CPDController::class, 'rejectRecord'])->name('cpd.admin.reject');
    });
});
