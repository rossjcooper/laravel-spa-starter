<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ProfileController;
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

Route::post('login', [LoginController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum'],], function () {
	Route::get('profile', [ProfileController::class, 'profile']);
	Route::post('profile', [ProfileController::class, 'update']);
	Route::post('changePassword', [PasswordController::class, 'changePassword']);
	Route::post('logout', [LogoutController::class, 'logout']);

});

