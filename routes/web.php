<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FormAnswerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    Route::get('/forms', [FormAnswerController::class, 'index'])->name('forms.index');
    Route::get('/forms/{form}', [FormAnswerController::class, 'show'])->name('forms.show');
    Route::post('/forms/{form}', [FormAnswerController::class, 'store'])->name('forms.store');
});
