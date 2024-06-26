<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactPersonController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerQueryController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\LabTestController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\QueryResultController;
use App\Http\Controllers\Api\FileUploadController;
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

// Auth
Route::resource('auth', AuthController::class);

//Operator
Route::resource('operator', OperatorController::class);

//Departments
Route::resource('department', DepartmentController::class);

//Customer
Route::resource('customer', CustomerController::class);

//Contact Person
Route::resource('contact-person', ContactPersonController::class);

//Lab Test Person
Route::resource('lab-test', LabTestController::class);

//Cusomer Queries
Route::resource('customer-query', CustomerQueryController::class);

//Cusomer Queries Results
Route::resource('query-result', QueryResultController::class);

//File Upload
Route::resource('upload', FileUploadController::class);
