<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        $url = match (auth()->user()->cargo) {
            'admin' => '/admin',
            'aqv' => '/aqv',
            'portaria' => '/portaria',
            'professor' => '/professor',
            default => '/',
        };
        return redirect($url);
    }
    return view('welcome');
})->name('home');

Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $url = match (auth()->user()->cargo) {
            'admin' => '/admin',
            'aqv' => '/aqv',
            'portaria' => '/portaria',
            'professor' => '/professor',
            default => '/',
        };
        return redirect($url);
    })->name('dashboard');
});

require __DIR__.'/settings.php';
