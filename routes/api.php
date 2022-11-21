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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('api/employee')->group(function()
{
    Route::get('/all',[employeeController::class,'listEmployees']);
    Route::get('/single{id}',[employeeController::class,'getSingleEmployee']);
    Route::post('/create',[employeeController::class,'createEmployee']);
    Route::delete('/delete/{id}',[employeeController::class,'deleteEmployee']);
    Route::put('/update/{id}',[employeeController::class,'updateEmployee']);
});