<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\VatRateController;

Route::middleware(['auth'])->group(function () {

    // Articles routes
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');


    //VatRates
    Route::get('/vatRates', [VatRateController::class, 'index'])->name('vat-rates.index');
    Route::get('/vatRates/create', [VatRateController::class, 'create'])->name('vat-rates.create');
    Route::post('/vatRates', [VatRateController::class, 'store'])->name('vat-rates.store');
    Route::get('/vatRates/{vatRate}', [VatRateController::class, 'show'])->name('vat-rates.show');
    Route::get('/vatRates/{vatRate}/edit', [VatRateController::class, 'edit'])->name('vat-rates.edit');
    Route::put('/vatRates/{vatRate}', [VatRateController::class, 'update'])->name('vat-rates.update');
    Route::delete('/vatRates/{vatRate}', [VatRateController::class, 'destroy'])->name('vat-rates.destroy');

    //Contact routes
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::get('/contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('/contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

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

    // VIES lookup route
    Route::post('/entities/vies-lookup', [App\Http\Controllers\EntityController::class, 'viesLookup']);
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
