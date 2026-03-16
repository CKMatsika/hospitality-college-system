<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OnlineExamController;
use App\Http\Controllers\OnlineLessonController;
use App\Http\Controllers\OnlineAssignmentController;
use App\Http\Controllers\CertificateController;

Route::middleware(['auth', 'verified'])->prefix('online-learning')->name('online-learning.')->group(function () {
    // Online Learning Dashboard
    Route::get('/dashboard', function () {
        return view('online-learning.dashboard');
    })->name('dashboard');
    
    Route::prefix('exams')->name('exams.')->group(function () {
        Route::get('/', [OnlineExamController::class, 'index'])->name('index');
        Route::get('/create', [OnlineExamController::class, 'create'])->name('create');
        Route::post('/', [OnlineExamController::class, 'store'])->name('store');
        Route::get('/{exam}', [OnlineExamController::class, 'show'])->name('show');
        Route::get('/{exam}/questions', [OnlineExamController::class, 'questions'])->name('questions');
        Route::post('/{exam}/questions', [OnlineExamController::class, 'storeQuestions'])->name('questions.store');
        Route::post('/{exam}/publish', [OnlineExamController::class, 'publish'])->name('publish');
        Route::get('/{exam}/take', [OnlineExamController::class, 'takeExam'])->name('take');
        Route::post('/{exam}/submit', [OnlineExamController::class, 'submitExam'])->name('submit');
        Route::get('/{exam}/results', [OnlineExamController::class, 'results'])->name('results');
        Route::get('/{submission}/grade', [OnlineExamController::class, 'grade'])->name('grade');
        Route::post('/{submission}/grade', [OnlineExamController::class, 'saveGrades'])->name('grade.save');
        Route::post('/{submission}/certificate', [OnlineExamController::class, 'generateCertificate'])->name('certificate');
    });
    
    Route::prefix('lessons')->name('lessons.')->group(function () {
        Route::get('/', [OnlineLessonController::class, 'index'])->name('index');
        Route::get('/create', [OnlineLessonController::class, 'create'])->name('create');
        Route::post('/', [OnlineLessonController::class, 'store'])->name('store');
        Route::get('/{lesson}', [OnlineLessonController::class, 'show'])->name('show');
        Route::get('/{lesson}/edit', [OnlineLessonController::class, 'edit'])->name('edit');
        Route::put('/{lesson}', [OnlineLessonController::class, 'update'])->name('update');
        Route::delete('/{lesson}', [OnlineLessonController::class, 'destroy'])->name('destroy');
        Route::post('/{lesson}/enroll', [OnlineLessonController::class, 'enroll'])->name('enroll');
        Route::post('/{lesson}/complete', [OnlineLessonController::class, 'complete'])->name('complete');
    });
    
    Route::prefix('assignments')->name('assignments.')->group(function () {
        Route::get('/', [OnlineAssignmentController::class, 'index'])->name('index');
        Route::get('/create', [OnlineAssignmentController::class, 'create'])->name('create');
        Route::post('/', [OnlineAssignmentController::class, 'store'])->name('store');
        Route::get('/{assignment}', [OnlineAssignmentController::class, 'show'])->name('show');
        Route::get('/{assignment}/submissions', [OnlineAssignmentController::class, 'submissions'])->name('submissions');
        Route::post('/{assignment}/submit', [OnlineAssignmentController::class, 'submit'])->name('submit');
        Route::post('/{submission}/grade', [OnlineAssignmentController::class, 'grade'])->name('grade');
    });
    
    Route::prefix('certificates')->name('certificates.')->group(function () {
        Route::get('/', [CertificateController::class, 'index'])->name('index');
        Route::get('/{certificate}', [CertificateController::class, 'show'])->name('show');
        Route::get('/{certificate}/verify', [CertificateController::class, 'verify'])->name('verify');
        Route::get('/{certificate}/download', [CertificateController::class, 'download'])->name('download');
    });
});
