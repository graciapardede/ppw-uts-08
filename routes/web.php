<?php

use Illuminate\Support\Facades\Route;

// Halaman HTML statis
Route::get('/', function () {
    return response()->file(public_path('index.html'));
});

Route::get('/index.html', function () {
    return response()->file(public_path('index.html'));
});

Route::get('/login.html', function () {
    return response()->file(public_path('login.html'));
});

// Route untuk Blade views (jika diperlukan)
Route::get('/courses', function () {
    return view('courses');
});

Route::get('/my-courses', function () {
    return view('my-courses');
});

// DEBUG: show PHP info for the web SAPI (visit /phpinfo in your browser)
Route::get('/phpinfo', function () {
    phpinfo();
});

// DEBUG: show PDO drivers available in the web SAPI (visit /pdo-drivers)
Route::get('/pdo-drivers', function () {
    return response()->json(PDO::getAvailableDrivers());
});
