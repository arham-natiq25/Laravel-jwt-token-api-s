<?php

use App\Http\Controllers\Api\ApiController;
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

Route::post('/register',[ApiController::class,"register"])->name('register');
Route::post('/login',[ApiController::class,"login"])->name('login');

Route::group(['middleware'=>'auth:api'],function () {
   Route::get('/profile',[ApiController::class,'profile'])->name('profile');
   Route::get('/refresh',[ApiController::class,'refreshToken'])->name('refresh');
   Route::get('/logout',[ApiController::class,'logout'])->name('logout');
});
