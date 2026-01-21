<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\Auth\LoginController;

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
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|string',
        'password' => 'nullable|string',
    ]);

    $email = $request->input('email');
    $name = Str::before($email, '@') ?: $email;

    // find or create a local user (no password check)
    $user = User::firstOrCreate(
        ['email' => $email],
        ['name' => $name, 'password' => bcrypt(Str::random(32))]
    );

    Auth::login($user);

    return redirect('/dashboard');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [VehicleController::class, 'index'])->name('dashboard');

    // Trash Management - MUST come BEFORE resource routes
    Route::get('/vehicles/trash', [VehicleController::class, 'trash'])->name('vehicles.trash');
    Route::post('/vehicles/{id}/restore', [VehicleController::class, 'restore'])->name('vehicles.restore');
    Route::delete('/vehicles/{id}/permanent-delete', [VehicleController::class, 'permanentDelete'])->name('vehicles.permanent-delete');
    Route::get('/vehicles/export/pdf', [VehicleController::class, 'exportPDF'])->name('vehicles.export-pdf');

    Route::get('/brands/trash', [BrandController::class, 'trash'])->name('brands.trash');
    Route::post('/brands/{id}/restore', [BrandController::class, 'restore'])->name('brands.restore');
    Route::delete('/brands/{id}/permanent-delete', [BrandController::class, 'permanentDelete'])->name('brands.permanent-delete');
    Route::get('/brands/export/pdf', [BrandController::class, 'exportPDF'])->name('brands.export-pdf');

    // Vehicles CRUD (RESOURCES - after trash routes)
    Route::resource('vehicles', VehicleController::class);

    // Brands CRUD
    Route::resource('brands', BrandController::class);

    // Brand Vehicles
    Route::get('/brands/{id}/vehicles', [BrandController::class, 'vehicles'])->name('brands.vehicles');

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
