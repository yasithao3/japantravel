<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
Route::group(['middleware' => ['role:manager']], function () {
    Route::get('/employees', [App\Http\Controllers\EmployeeController::class, 'index'])->name('employees');
    Route::get('/create-employee', [App\Http\Controllers\EmployeeController::class, 'create'])->name('create-employee');
    Route::post('/create-employee', [App\Http\Controllers\EmployeeController::class, 'store'])->name('store-employee');
    Route::post('/fetch-employees', [App\Http\Controllers\EmployeeController::class, 'fetchList'])->name('fetch-employees');
    Route::post('/edit-employee/{$empId}', [App\Http\Controllers\EmployeeController::class, 'editEmployee'])->name('edit-employee');
    Route::post('/review-leaves', [App\Http\Controllers\LeavesController::class, 'reveiewLeaveRequests'])->name('review-leaves');
});
Route::group(['middleware' => ['role:manager|employee']], function () {
    Route::get('/leaves', [App\Http\Controllers\LeavesController::class, 'index'])->name('leaves');
    Route::get('/apply-leaves', [App\Http\Controllers\LeavesController::class, 'create'])->name('apply-leaves');
    Route::post('/apply-leaves', [App\Http\Controllers\LeavesController::class, 'store'])->name('store-apply-leaves');
    Route::post('/fetch-leaves', [App\Http\Controllers\LeavesController::class, 'fetchList'])->name('fetch-leaves');
});
Auth::routes();


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
