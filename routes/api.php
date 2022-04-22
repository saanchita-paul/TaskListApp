<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/task-list',[TaskController::class,'list']);
    Route::post('/tasks',[TaskController::class,'store']);
    Route::put('/tasks/{id}',[TaskController::class,'update']);
    Route::delete('/tasks/{id}',[TaskController::class,'destroy']);
    Route::delete('/deleteusertask/{userid}/{taskid}',[TaskController::class,'deleteUserTask']);
    Route::post('/logout',[AuthController::class,'logout']);
});

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);