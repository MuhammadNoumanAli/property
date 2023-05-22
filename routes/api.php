<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Superadmin\SuperadminController;
use App\Http\Controllers\API\PermissionController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::post('/register', [RegisterController::class, 'registerAdminOrAgency']);
Route::get('/user-details', [LoginController::class, 'userDetails'])->name('api.user.details');
Route::get('/logout', [LoginController::class, 'logoutUser']);






Route::middleware(['auth:superadmin-api'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Super Admin [Agencies] Routes
    |--------------------------------------------------------------------------
    |
    */


//    Route::apiResource('agencies', SuperadminController::class);

    Route::get('/agencies', [SuperadminController::class, 'indexAgency'])->name('agency.index');
    Route::get('/agencies/{agency}', [SuperadminController::class, 'showAgency'])->name('agency.show');
    Route::get('/agencies/{agency}/edit', [SuperadminController::class, 'editAgency'])->name('agency.edit');
    Route::patch('/agencies/{agency}', [SuperadminController::class, 'updateAgency'])->name('agency.update');
    Route::delete('/agencies/{agency}', [SuperadminController::class, 'destroyAgency'])->name('agency.destroy');







    /*
    |--------------------------------------------------------------------------
    | Super Admin [Admins] Routes
    |--------------------------------------------------------------------------
    |
    */

//    Route::apiResource('admins', SuperadminController::class);

    Route::get('/admins', [SuperadminController::class, 'indexAdmin'])->name('admins.index');
    Route::get('/admins/{admin}', [SuperadminController::class, 'showAdmin'])->name('admins.show');
    Route::get('/admins/{admin}/edit', [SuperadminController::class, 'editAdmin'])->name('admins.edit');
    Route::patch('/admins/{admin}', [SuperadminController::class, 'updateAdmin'])->name('admins.update');
    Route::delete('/admins/{admin}', [SuperadminController::class, 'destroyAdmin'])->name('admins.destroy');


});





