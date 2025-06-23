<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoalController;

// Halaman utama (Welcome)
Route::get('/', fn () => view('welcome'));

// ===========================
// Auth Routes
// ===========================
Route::middleware('guest')->group(function () {
    Route::get('register', fn () => view('auth.register'))->name('register');
    Route::post('register', [AuthController::class, 'register'])->name('register-post');

    Route::get('login', fn () => view('auth.login'))->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login-post');
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ===========================
// Protected Routes
// ===========================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('dashboard', [PageController::class, 'dashboard'])->name('dashboard');

    // Transactions
    Route::get('transactions', [PageController::class, 'transactions'])->name('transactions');
    Route::post('transactions/store', [TransactionController::class, 'store'])->name('transaction.store');

    // Accounts
    Route::prefix('accounts')->name('pages.accounts.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::post('/', [AccountController::class, 'store'])->name('store');
        Route::get('{account}/edit', [AccountController::class, 'edit'])->name('edit');
        Route::put('{account}', [AccountController::class, 'update'])->name('update');
        Route::delete('{account}', [AccountController::class, 'destroy'])->name('destroy');
    });

    // Budgets
    Route::prefix('budgets')->name('pages.budgets.')->group(function () {
        Route::get('/', [BudgetController::class, 'index'])->name('index');
        Route::post('/', [BudgetController::class, 'store'])->name('store');
        Route::delete('{budget}', [BudgetController::class, 'destroy'])->name('destroy');
    });

    // Categories
    Route::prefix('categories')->name('pages.categories.')->group(function () {
        Route::get('/', [PageController::class, 'categories'])->name('index');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('{category}', [CategoryController::class, 'update'])->name('update');
        Route::delete('{category}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    // Goals
    Route::prefix('goals')->name('pages.goals.')->group(function () {
        Route::get('/', [GoalController::class, 'index'])->name('index');
        Route::post('/', [GoalController::class, 'store'])->name('store');
        Route::get('{goal}/edit', [GoalController::class, 'edit'])->name('edit');
        Route::put('{goal}', [GoalController::class, 'update'])->name('update');
        Route::delete('{goal}', [GoalController::class, 'destroy'])->name('destroy');
    });

    // Reports
    Route::get('reports', [PageController::class, 'reports'])->name('reports');

    // pdf
    Route::get('pdf/transactions', [PageController::class, 'pdf'])->name('pages.reports.exportPdf');


    // Fallback create-account (?)
    Route::get('/create-account', fn () => view('auth.login'))->name('create.account');
});
