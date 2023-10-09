<?php

use App\Livewire\Auth\{Login, Register};
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('auth.login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/logout', fn () => auth()->logout())->name('auth.logout');

Route::middleware(['auth'])
    ->group(function () {
        Route::get('/', Welcome::class)->name('dashboard');
    });
