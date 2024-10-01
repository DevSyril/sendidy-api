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
    Route::post('reset-password', action: [AuthController::class, 'resetPassword']);
    Route::patch('change-password/{id}', [UserController::class, 'changePassword']);
    
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('edit-profile', [UserController::class, 'update']);
        Route::get('list-users', [UserController::class, 'index']);
        Route::get('user-groups', [GroupController::class, 'getUserGroups']);
        Route::get('current-user', [AuthController::class, 'getCurrentUser']);
        Route::get('logout-user', [AuthController::class, 'logout']);
        Route::post('create-group', [GroupController::class, 'store']);
        Route::post('add-member', [GroupMemberController::class, 'store']);
        Route::post('upload-file', [FileController::class, 'store']);
        Route::get('show-group/{id}', [GroupController::class, 'show']);
        Route::get('show-group-members/{id}', [GroupMemberController::class, 'getGroupMembers']);
        Route::get('search-group/{group}', [GroupController::class, 'searchGroup']);
        Route::get('group-files/{id}', [FileController::class, 'groupFiles']);
        Route::post('update-group/{id}', [GroupController::class, 'update']);
        Route::delete('delete-group/{id}', [GroupController::class, 'destroy']);
        Route::get('files-download/{id}', [FileController::class, 'download']);
    });


});
