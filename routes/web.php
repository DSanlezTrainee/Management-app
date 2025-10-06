<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware(['auth', 'verified'])->group(function () {
    // Clients and Suppliers filtered views
    Route::get('/clients', [App\Http\Controllers\EntityController::class, 'clients'])->name('entities.clients');
    Route::get('/suppliers', [App\Http\Controllers\EntityController::class, 'suppliers'])->name('entities.suppliers');

    // Entities routes
    Route::get('/entities', [App\Http\Controllers\EntityController::class, 'index'])->name('entities.index');
    Route::get('/entities/create', [App\Http\Controllers\EntityController::class, 'create'])->name('entities.create');
    Route::post('/entities', [App\Http\Controllers\EntityController::class, 'store'])->name('entities.store');
    Route::get('/entities/{entity}', [App\Http\Controllers\EntityController::class, 'show'])->name('entities.show');
    Route::get('/entities/{entity}/edit', [App\Http\Controllers\EntityController::class, 'edit'])->name('entities.edit');
    Route::put('/entities/{entity}', [App\Http\Controllers\EntityController::class, 'update'])->name('entities.update');
    Route::delete('/entities/{entity}', [App\Http\Controllers\EntityController::class, 'destroy'])->name('entities.destroy');
});


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
