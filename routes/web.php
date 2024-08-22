<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return view('test');
});
// Route::get('/admin/login/', 'Filament\Auth\Http\Controllers\LoginController@showLoginForm')->name('admin.dashboard');
