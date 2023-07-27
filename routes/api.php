<?php

use App\Http\Controllers\UserController;
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


Route::post('/register', [UserController::class, 'register'])->name('register')->middleware('guest');
Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('guest');
Route::post('/logout',[UserController::class,'logout'])->name('logout')->middleware('auth:sanctum');
Route::post('/email/verify',[UserController::class,'verifyEmail'])->name('verify')->middleware('auth:sanctum');

Route::post('/password-reset',[UserController::class,'resetPassword'])->name('resetPassword')->middleware('auth:sanctum');
Route::post('/forget-password', [UserController::class, 'forgetPassword'])->name('forgetPassword')->middleware('guest');
Route::post('/verify-pin',[UserController::class,'verifyPin'])->name('verifyPin')->middleware('guest');


// Route::controller(UserController::class)->group(function(){

//     Route::post('/register', 'register');
//     Route::post('/login', 'login');
//     Route::post('/logout', 'logout');

// });

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
