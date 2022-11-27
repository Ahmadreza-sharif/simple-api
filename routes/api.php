<?php

use App\Http\Controllers\api\v1\authorController;
use App\Http\Controllers\api\v1\bookController;
use App\Http\Controllers\api\v1\courseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\employeeController;
use App\Http\Controllers\api\v1\projectController;
use App\Http\Controllers\api\v1\studentController;
use App\Http\Controllers\api\v1\userController;

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

    Route::prefix('sanctum')->group(function () {
        Route::post('/login', [studentController::class, 'login']);
        Route::post('/register', [studentController::class, 'register']);

        Route::group(['middleware' => ["auth:sanctum"]], function () {

            Route::get('/profile', [studentController::class, 'profile']);
            Route::get('/logout', [studentController::class, 'logout']);

            Route::post('/create-project', [projectController::class, 'createProject']);
            Route::get('/list-project', [projectController::class, 'listProject']);
            Route::get('/single-project/{id}', [projectController::class, 'singleProject']);
            Route::delete('/delete-project/{id}', [projectController::class, 'deleteProject']);
        });
    });

    Route::prefix('jwt')->group(function () {
        Route::post('/login',[userController::class,'login']);
        Route::post('/register',[userController::class,'register']);
        
        Route::group(['middleware' => ['auth:api']],function () {
            Route::post('/create', [courseController::class,'courseEnrollment']);
            Route::get('/profile', [userController::class,'profile']);
            Route::get('/logout', [userController::class,'logout']);
            Route::get('/total', [courseController::class,'total']);
            Route::delete('/delete/{id}', [courseController::class,'deleteCourse']);
        });
    });

    Route::prefix('passport')->group(function () {
        Route::post('/login',[authorController::class,'login']);
        Route::post('/register',[authorController::class,'register']);
        
        Route::group(['middleware' => ['auth:api']],function () {
            Route::post('/create', [bookController::class,'create']);
            Route::get('/list', [bookController::class,'list']);
            Route::get('/single/{id}', [bookController::class,'single']);
            Route::post('/update/{id}', [bookController::class,'update']);
            Route::delete('/delete', [bookController::class,'delete']); 
        });
    });
});
