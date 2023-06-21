<?php

use App\Http\Controllers\EmployeeReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('Home');
});
Route::get('/registation',[UserController::class,'registerForm'])->middleware('guest');
Route::post('/registered',[UserController::class,'saveOwnerRegistration']);
Route::post('/logout',[UserController::class,'logout']);
Route::get('/login',[UserController::class,'showLoginPage'])->name('login')->middleware('guest');
Route::post('/logged',[UserController::class,'userLogin']);
Route::get('/employee-list',[UserController::class,'employeeList'])->middleware('auth')->middleware('auth', 'owner');
Route::get('/addEmployeeForm', [UserController::class, 'addEmployeeForm'])->middleware('auth', 'owner');
Route::post('/employee-registered',[UserController::class,'saveEmployeeRegistration']);


Route::get('/employee-report', [EmployeeReportController::class, 'employeeReport'])->middleware('auth', 'owner');
Route::get('/check-in-out-page', [EmployeeReportController::class, 'showCheck_InOut'])->middleware('auth','employee');
Route::post('/check-in', [EmployeeReportController::class, 'checkIn'])->middleware('auth','employee');
Route::post('/check-out', [EmployeeReportController::class, 'checkOut'])->middleware('auth','employee');
Route::get('/individual-report/{employeeId}', [EmployeeReportController::class, 'individualReport'])->middleware('auth', 'owner');






