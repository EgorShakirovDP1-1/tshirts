<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThingController;
use App\Http\Controllers\DrawingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Thing routes


    Route::middleware('auth')->group(function () {
        Route::get('/profile/create', [ThingController::class, 'create'])->name('profile.create');
        Route::post('/profile/store', [ThingController::class, 'store'])->name('profile.store');
    });

    // Drawing routes
    Route::get('/draw', function () {
        return view('draw');
    })->name('draw');

    Route::post('/drawings', [DrawingController::class, 'store'])->name('drawings.store');
});

require __DIR__.'/auth.php';
