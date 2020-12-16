<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('user', [
    \App\Http\Controllers\UserController::class, 'index'
]);

/* Авторизация */
Route::prefix('auth')->group(function () {

    Route::post('signup', [
        \App\Http\Controllers\AuthController::class, 'signup'
    ]);

    Route::post('signin', [
        \App\Http\Controllers\AuthController::class, 'signin'
    ]);

    Route::middleware('auth:sanctum')->get('signout', [
        \App\Http\Controllers\AuthController::class, 'signout'
    ]);

});
