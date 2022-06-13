<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'admin.'], function () {
    Route::get('/', [Admin\LoginController::class, 'index'])->name('login');
    Route::post('/login', [Admin\LoginController::class, 'login'])->name('login.post');

    Route::group(['middleware' => 'admin', 'prefix' => 'backend-admin'], function () {
        Route::post('/logout', [Admin\LoginController::class, 'logout'])->name('logout');
        Route::get('dashboard', [Admin\HomeController::class, 'index'])->name('home');
    });
});
