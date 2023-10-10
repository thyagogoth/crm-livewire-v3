<?php

use App\Livewire\Auth\{Login, Password, Register};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('auth.login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', fn () => auth()->logout())->name('auth.logout');
Route::get('/password/recovery', Password\Recovery::class)->name('auth.password.recovery');
Route::get('/password/reset', fn()=>'oi')->name('password.reset');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/', Welcome::class)->name('dashboard');
    });
