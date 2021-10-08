<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\CustomerController;




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

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('logout',  [AuthController::class,'logout']);
    Route::post('refresh',  [AuthController::class,'refresh']);
    Route::post('me',  [AuthController::class,'me']);


});

//Api employee Routes
Route::apiResource('/employee', EmployeeController::class );

//Api supplier Routes
Route::apiResource('/supplier', SupplierController::class );

//Api category Routes
Route::apiResource('/category', CategoryController::class );

//Api product Routes
Route::apiResource('/product', ProductController::class );

//Api expense Routes
Route::apiResource('/expense', ExpenseController::class );

//Api Salary Routes

Route::post('/salary/paid/{id}', [SalaryController::class, 'salaryPaid'] );

Route::get('/salary', [SalaryController::class, 'allSalary'] );

Route::get('/salary/view/{id}', [SalaryController::class, 'viewSalary'] );

Route::get('/salary/edit/{id}', [SalaryController::class, 'editSalary'] );

Route::post('/salary/update/{id}', [SalaryController::class, 'updateSalary'] );

//Stock Routes
Route::post('/stock/update/{id}', [ProductController::class, 'updateStock'] );

//Api Customer Routes
Route::apiResource('/customer', CustomerController::class );
