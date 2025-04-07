<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return response()->json(['message' => 'Welcome to the API']);
// });

Route::get('/register', [App\Http\Controllers\authViews::class, 'register'])->name('register');
Route::get('/connecter', [App\Http\Controllers\authViews::class, 'connecter'])->name('connecter');
Route::get('/resetpassword', [App\Http\Controllers\authViews::class, 'resetpassword'])->name('resetpassword');