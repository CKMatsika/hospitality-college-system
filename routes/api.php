<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StudentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Authentication routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/user', [AuthController::class, 'user']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    // Student routes (require student role)
    Route::middleware('role:student')->prefix('/student')->group(function () {
        Route::get('/profile', [StudentController::class, 'profile']);
        Route::get('/grades', [StudentController::class, 'grades']);
        Route::get('/attendance', [StudentController::class, 'attendance']);
        Route::get('/fees', [StudentController::class, 'fees']);
        Route::get('/schedule', [StudentController::class, 'schedule']);
    });

    // Staff routes (require staff roles)
    Route::middleware('role:teacher,academic-manager,admin,super-admin')->prefix('/staff')->group(function () {
        Route::get('/students', function () {
            return response()->json(['message' => 'Staff students endpoint']);
        });
        Route::get('/courses', function () {
            return response()->json(['message' => 'Staff courses endpoint']);
        });
    });

    // Admin routes (require admin roles)
    Route::middleware('role:admin,super-admin')->prefix('/admin')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Admin dashboard endpoint']);
        });
        Route::get('/reports', function () {
            return response()->json(['message' => 'Admin reports endpoint']);
        });
    });
});
