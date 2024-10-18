<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BankController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'firstPage'])->name('welcome');
Route::get('/auth/login', [LoginController::class, 'index'])->name('auth.login');
Route::post('/auth/login/post', [LoginController::class, 'login'])->name('login.post');
Route::get('/auth/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
   
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.list');
    Route::post('/admin/user/post', [UserController::class, 'store'])->name('admin.user.post');
    Route::post('/admin/user/update', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/admin/user/destroy', [UserController::class, 'destroy'])->name('admin.user.destroy');

    Route::get('/admin/exchange', [ExchangeController::class, 'exchangeList'])->name('admin.exchange.list');
    Route::post('/admin/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.store');
    Route::post('/admin/exchange/destroy', [ExchangeController::class, 'destroy'])->name('admin.exchange.destroy');

    Route::get('/admin/bank', [BankController::class, 'index'])->name('admin.bank.list');

});

Route::group(['middleware' => 'assistant'], function () {
    Route::get('/assistant', [AssistantController::class, 'index'])->name('assistant.dashboard');
});

Route::group(['middleware' => 'exchange'], function () {
    Route::get('/exchange', [ExchangeController::class, 'index'])->name('exchange.dashboard');
});