<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\SchedulerController;
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
//users
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/new-formation', [FormationController::class, 'addFormation']);
    Route::post('/logout', [AuthController::class, 'logout']);
    //ajouter une demande pour devenir mentor
    Route::post('/new-query', [DemandeController::class, 'newQuery']);
    Route::get('/get-formations', [FormationController::class, 'getFormation']);
    Route::get('/get-my-formations', [FormationController::class, 'getMyFormation'])->middleware('role:mentor');
    Route::post('/new-schedule/{calendar}', [SchedulerController::class, 'newSchedule']);
});
//admins
Route::prefix('/admin')
    ->middleware(['auth:sanctum', 'admin'])->group(function () {
        Route::post('/login', [AdminController::class, 'login'])->withoutMiddleware(['auth:sanctum', 'admin']);
        Route::post('/logout', [AdminController::class, 'logout']);
        //pour valider une demande
        Route::post('/validate/{user}/{demande}', [DemandeController::class, 'validateQuery']);
        Route::get('get-demandes', [DemandeController::class, 'getDemande']);
    });
//data: {email, password}
Route::post('login', [AuthController::class, 'login']);
//data: {email, password, full_name}
Route::post('register', [AuthController::class, 'register']);

//Route for testing api 
//Route for testing api 
Route::get('get-magic-number', function () {
    return response()->json(['your magic number' => random_int(1, 100)]);
});
