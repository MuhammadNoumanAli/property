<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\ForgotPasswordController;
use App\Http\Controllers\API\Auth\ResetPasswordController;

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

Route::post('/login', [LoginController::class, 'loginUser']);
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);


//Route::post('agency/forgot-password', 'App\Http\Controllers\AgencyAuth\ForgotPasswordController@sendResetLinkEmail')->name('agency.password.email');
//Route::post('admin/forgot-password', 'App\Http\Controllers\AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
//Route::post('superadmin/forgot-password', 'App\Http\Controllers\SuperAdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('superadmin.password.email');
