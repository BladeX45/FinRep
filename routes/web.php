<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('register', function(){
    return view('auth.register');
})->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register-post');


// Route for Login
Route::get('login', function(){
    return view('auth.login');
})->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login-post');

// Route for transaction
Route::get('transactions', [PageController::class, 'transactions'])
    ->middleware('auth')
    ->name('transactions');

// Store transaction
Route::post('/transactions/store', [TransactionController::class, 'store'])->name('transaction.store');


Route::get('dashboard', [PageController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/create-account', function(){
    return view('auth.login');
})->middleware('auth')->name('create.account');
// logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


// Routes for accounts
Route::get('accounts', [AccountController::class, 'index'])
    ->middleware('auth')
    ->name('pages.accounts.index');

Route::post('accounts', [AccountController::class, 'store'])
    ->middleware('auth')
    ->name('pages.accounts.store');

Route::get('accounts/{account}/edit', [AccountController::class, 'edit'])
    ->middleware('auth')
    ->name('pages.accounts.edit');

Route::put('accounts/{account}', [AccountController::class, 'update'])
    ->middleware('auth')
    ->name('pages.accounts.update');

Route::delete('accounts/{account}', [AccountController::class, 'destroy'])
    ->middleware('auth')
    ->name('pages.accounts.destroy');

Route::middleware(['auth'])->prefix('budgets')->name('pages.budgets.')->group(function () {
    Route::get('/', [BudgetController::class, 'index'])->name('index');
    Route::post('/', [BudgetController::class, 'store'])->name('store');
    Route::delete('/{budget}', [BudgetController::class, 'destroy'])->name('destroy');
});
