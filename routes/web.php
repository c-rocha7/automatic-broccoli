<?php

use App\Http\Controllers\FormAnswerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Rotas simples de autenticação
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended('/forms');
    }

    return back()->withErrors([
        'email' => 'As credenciais fornecidas não coincidem com nossos registros.',
    ]);
})->name('login.store');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
})->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/forms', [FormAnswerController::class, 'index'])->name('forms.index');
    Route::get('/forms/{form}', [FormAnswerController::class, 'show'])->name('forms.show');
    Route::post('/forms/{form}', [FormAnswerController::class, 'store'])->name('forms.store');
});
