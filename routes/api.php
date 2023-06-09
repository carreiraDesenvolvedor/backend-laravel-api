<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;

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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::controller(\App\Http\Controllers\API\ArticlesController::class)->prefix('article')->group(function () {
    Route::get('find', 'find');
});
