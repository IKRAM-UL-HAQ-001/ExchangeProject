<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\DepositWithdrawalController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\BankBalanceController;
use App\Http\Controllers\CashController;
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
    
    //admin dashboard
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    
    // exchange user
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.list');
    Route::post('/admin/user/post', [UserController::class, 'store'])->name('admin.user.post');
    Route::post('/admin/user/update', [UserController::class, 'update'])->name('admin.user.update');
    Route::post('/admin/user/destroy', [UserController::class, 'destroy'])->name('admin.user.destroy');
    
    // exchange
    Route::get('/admin/exchange', [ExchangeController::class, 'exchangeList'])->name('admin.exchange.list');
    Route::post('/admin/exchange/post', [ExchangeController::class, 'store'])->name('admin.exchange.store');
    Route::post('/admin/exchange/destroy', [ExchangeController::class, 'destroy'])->name('admin.exchange.destroy');
    
    //bank
    Route::get('/admin/bank', [BankController::class, 'index'])->name('admin.bank.list');
    Route::post('/admin/bank/post', [BankController::class, 'store'])->name('admin.bank.store');
    Route::post('/admin/bank/destroy', [BankController::class, 'destroy'])->name('admin.bank.destroy');
    
    // deposit withdrawal
    Route::get('/admin/deposit-withdrawal', [DepositWithdrawalController::class, 'index'])->name('admin.deposit_withdrawal.list');
    Route::post('/admin/deposit-withdrawal/destroy', [DepositWithdrawalController::class, 'destroy'])->name('admin.deposit_withdrawal.destroy');    
    
    //expense
    Route::get('/admin/expense', [ExpenseController::class, 'index'])->name('admin.expense.list');
    Route::post('/admin/expense/destroy', [ExpenseController::class, 'destroy'])->name('admin.expense.destroy');

    //bank Balance
    Route::get('/admin/bankBalance', [BankBalanceController::class, 'index'])->name('admin.bank_balance.list');
    Route::post('/admin/bankBalance/destroy', [BankBalanceController::class, 'destroy'])->name('admin.bank_balance.destroy');
});

Route::group(['middleware' => 'assistant'], function () {
    Route::get('/assistant', [AssistantController::class, 'index'])->name('assistant.dashboard');
});

Route::group(['middleware' => 'exchange'], function () {

    //Exchange Dashboard
    Route::get('/exchange', [ExchangeController::class, 'index'])->name('exchange.dashboard');

    //Exchange Cash
    Route::get('/exchange/cash', [CashController::class, 'index'])->name('exchange.cash.list');
    Route::post('/exchange/cash/store', [CashController::class, 'store'])->name('exchange.cash.store');
    Route::post('/exchange/cash/destroy', [CashController::class, 'destroy'])->name('exchange.cash.destroy');
});