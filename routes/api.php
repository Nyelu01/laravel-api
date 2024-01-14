<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\Users\UserController;
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

//Registration
Route::post('register', [UserController::class, 'register']);

//Authentication
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    //User must me authenticated
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout/{userId}', [AuthController::class, 'logout']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
    });
});



//Authenticated routes
Route::middleware('auth:sanctum')->group(function() {
    //Posts
    Route::resource('posts', PostController::class);

});


//Posts
