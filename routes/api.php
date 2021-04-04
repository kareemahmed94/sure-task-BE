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

Route::get('/user', [\App\Http\Controllers\UserController::class , 'user'])->middleware('auth:api');

Route::group(['prefix' => 'users' , 'middleware' => 'auth:api'], function () {

    Route::get('/', [\App\Http\Controllers\UserController::class , 'index']);

    Route::get('/{userID}', [\App\Http\Controllers\UserController::class , 'show']);

    Route::patch('/update/{userID}', [\App\Http\Controllers\UserController::class , 'update']);

    Route::delete('/{userID}', [\App\Http\Controllers\UserController::class , 'destroy']);

});

Route::group(['prefix' => 'auth'], function () {

    Route::post('/login', [\App\Http\Controllers\AuthController::class , 'login']);

});

Route::group(['prefix' => 'register'], function () {

    Route::post('/', [\App\Http\Controllers\RegisterController::class , 'register']);

});

Route::group(['prefix' => 'verify'], function () {

    Route::post('/', [\App\Http\Controllers\VerificationController::class , 'verifyUser']);

});
