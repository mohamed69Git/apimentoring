<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FormationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/formations', [FormationController::class, 'getFormation']);
});
//data: {email, password}
Route::post('login', [AuthController::class, 'login']);
//data: {email, password, full_name}
Route::post('register', [AuthController::class, 'register']);
