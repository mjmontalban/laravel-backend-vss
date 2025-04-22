<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    });

    Route::get('/admin/settings', function () {
        return view('admin.settings');
    });

    Route::get('/admin/users', function () {
        return view('admin.users');
    });
});




