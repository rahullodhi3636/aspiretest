<?php

use App\Http\Controllers\LoanApplicationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('loan_application', [LoanApplicationController::class, 'index'])->name('loan_application');
Route::get('loan_application/create', [LoanApplicationController::class, 'create'])->name('loan_application/create');
Route::post('loan_application/create', [LoanApplicationController::class, 'store'])->name('loan_application/create');
Route::get('loan_application/approve/{id}', [LoanApplicationController::class, 'approve'])->name('loan_application/approve');
Route::get('loan_application/{id}', [LoanApplicationController::class, 'show']);
Route::get('pay/{id}', [LoanApplicationController::class, 'pay']);
Route::post('loan_application/pay', [LoanApplicationController::class, 'pay_installment'])->name('loan_application/pay');
//Route::resource('/loan_application',LoanApplicationController::class);
