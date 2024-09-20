<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\GroupMemberController;
use App\Http\Controllers\OtpCodeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1.0.0')->group(function () {

    Route::post('login-user', [AuthController::class, 'login']);
    Route::post('create-user', [AuthController::class, 'store']);
    Route::post('check-otp', [OtpCodeController::class, 'checkOtpCode']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
    Route::patch('change-password/{id}', [UserController::class, 'changePassword']);
    Route::post('edit-profile/{id}', [UserController::class, 'update']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('logout-user', [AuthController::class, 'logout']);
        Route::post('create-group', [GroupController::class, 'store']);
        Route::post('add-member', [GroupMemberController::class, 'store']);
        Route::post('upload-file', [FileController::class, 'store']);
    });

    Route::post('update-group/{id}', [GroupController::class, 'update']);
    Route::get('show-group/{id}', [GroupController::class, 'show']);
    Route::delete('delete-group/{id}', [GroupController::class, 'destroy']);


});
