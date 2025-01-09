<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin-only', function () {
        return response()->json(['message' => 'Welcome, Admin!']);
    });
});

Route::middleware(['auth', 'upload.permission'])->group(function () {
    Route::post('/upload', [DocumentController::class, 'upload']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/files', action: [DocumentController::class, 'index']);    // List all files
    Route::get('/files/{id}/download', [DocumentController::class, 'download']); // Download a file
});
