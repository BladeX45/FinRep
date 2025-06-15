<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

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


route::get('dashboard', function () {
    return view('pages.dashboard');
})->middleware('auth')->name('dashboard');
Route::get('/create-account', function(){
    return view('auth.login');
})->middleware('auth')->name('create.account');
// logout
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
