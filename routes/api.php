<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
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
Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'user'
], function () {
    Route::post("/register",[UserController::class,"register"]);
    Route::post("/login",[UserController::class,"login"]);
    Route::get("/me",[UserController::class,"me"]);
});
Route::group([
    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'student'
], function () {
    Route::post("/add",[StudentController::class,"addStudent"]);
    Route::get("/getall",[StudentController::class,"getAllStudents"]);
    Route::get("/get/{roll}",[StudentController::class,"getStudent"]);
    Route::get("/getroll/{roll}",[StudentController::class,"getStudentroll"]);
    Route::post("/addfee",[StudentController::class,"addFee"]);
    Route::get("/getfee/{id}",[StudentController::class,"getFee"]);
    Route::get("/me",[UserController::class,"me"]);
});
