<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademicIntegrationController;

/*
|--------------------------------------------------------------------------
| Academic Integration Routes
|--------------------------------------------------------------------------
|
| Routes for comprehensive integration between Academic, LMS, and Online Learning systems
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Main Academic Integration Dashboard
    Route::get('/academic-integration', [AcademicIntegrationController::class, 'dashboard'])->name('academic-integration.dashboard');
    
    // Student Academic Progress
    Route::get('/academic-integration/student/{student}/progress', [AcademicIntegrationController::class, 'academicProgress'])->name('academic-integration.progress');
    
    // Course Integration Overview
    Route::get('/academic-integration/course/{course}', [AcademicIntegrationController::class, 'courseIntegration'])->name('academic-integration.course');
    
    // Auto-Enrollment Management
    Route::get('/academic-integration/auto-enrollment', [AcademicIntegrationController::class, 'autoEnrollment'])->name('academic-integration.auto-enrollment');
    Route::post('/academic-integration/auto-enrollment/process', [AcademicIntegrationController::class, 'processAutoEnrollment'])->name('academic-integration.auto-enrollment.process');
    
    // Advanced Analytics
    Route::get('/academic-integration/analytics', [AcademicIntegrationController::class, 'analytics'])->name('academic-integration.analytics');
    
    // AI-Powered Recommendations
    Route::get('/academic-integration/student/{student}/recommendations', [AcademicIntegrationController::class, 'recommendations'])->name('academic-integration.recommendations');
    
    // Course Completion Sync
    Route::get('/academic-integration/sync-completion', [AcademicIntegrationController::class, 'syncCompletionPage'])->name('academic-integration.sync-completion.page');
    Route::post('/academic-integration/sync-completion', [AcademicIntegrationController::class, 'syncCompletion'])->name('academic-integration.sync-completion');
});
