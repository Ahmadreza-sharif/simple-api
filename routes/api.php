<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\employeeController;
use App\Http\Controllers\api\v1\projectController;
use App\Http\Controllers\api\v1\studentController;

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

Route::prefix('v1/')->group(function () {

    Route::prefix('employees')->group(function () {
        Route::get('/', [employeeController::class, 'listEmployees']);
        Route::get('/{id}', [employeeController::class, 'getSingleEmployee'])->where(['id' => '[0-9]+']);
        Route::post('/', [employeeController::class, 'createEmployee']);
        Route::delete('/{id}', [employeeController::class, 'deleteEmployee']);
        Route::put('/{id}', [employeeController::class, 'updateEmployee']);
    });

    Route::post('/login', [studentController::class,'login']);
    Route::post('/register', [studentController::class,'register']);
    
    Route::group(['middleware' => ["auth:sanctum"]],function () {

        Route::get('/profile',[studentController::class,'profile']);
        Route::get('/logout',[studentController::class,'logout']);

        Route::post('/create-project',[projectController::class,'createProject']);
        Route::get('/list-project',[projectController::class,'listProject']);
        Route::get('/single-project/{id}',[projectController::class,'createProject']);
        Route::get('/delete-project/{id}',[projectController::class,'deleteProject']);
    });
});
