<?php

use Illuminate\Support\Facades\Route;

// Add the named identifier so route('login') resolves correctly
Route::get('/', function () {
    return view('login');
})->name('login');