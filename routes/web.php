<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Auth\LoginController; // Create this if wala pa

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage - redirect depende sa authentication
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
})->name('home');

// Login form
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Login POST
Route::post('/login', [LoginController::class, 'login']);


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [VehicleController::class, 'index'])->name('dashboard');

    // Vehicles CRUD (RESOURCES ONLY — DO NOT DUPLICATE)
    Route::resource('vehicles', VehicleController::class);

    // Brands CRUD
    Route::resource('brands', BrandController::class);

    // Profile
    Route::get('/settings/profile', function() {
        return view('settings.profile'); 
    })->name('settings.profile');

    // Logout
    Route::post('/logout', function() {
        Auth::logout();
        return redirect('/login'); 
    })->name('logout');
});
