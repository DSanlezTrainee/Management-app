
<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\VatRateController;




Route::middleware(['auth'])->group(function () {

    // Company Routes 
    Route::get('company', [\App\Http\Controllers\CompanyController::class, 'edit'])->name('settings.company.edit');
    Route::match(['put', 'post'], 'company', [\App\Http\Controllers\CompanyController::class, 'update'])->name('settings.company.update');

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');
    Route::delete('/logs/{id}', [LogController::class, 'destroy'])->name('logs.destroy');

    Route::resource('roles', App\Http\Controllers\RoleController::class);

    // User management routes  
    Route::resource('users', App\Http\Controllers\UserController::class);

    // Supplier Invoices routes
    Route::get('/supplier-invoices', [App\Http\Controllers\SupplierInvoiceController::class, 'index'])->name('supplier-invoices.index');
    Route::get('/supplier-invoices/create', [App\Http\Controllers\SupplierInvoiceController::class, 'create'])->name('supplier-invoices.create');
    Route::post('/supplier-invoices', [App\Http\Controllers\SupplierInvoiceController::class, 'store'])->name('supplier-invoices.store');
    Route::get('/supplier-invoices/{supplierInvoice}', [App\Http\Controllers\SupplierInvoiceController::class, 'show'])->name('supplier-invoices.show');
    Route::get('/supplier-invoices/{supplierInvoice}/edit', [App\Http\Controllers\SupplierInvoiceController::class, 'edit'])->name('supplier-invoices.edit');
    Route::put('/supplier-invoices/{supplierInvoice}', [App\Http\Controllers\SupplierInvoiceController::class, 'update'])->name('supplier-invoices.update');
    Route::delete('/supplier-invoices/{supplierInvoice}', [App\Http\Controllers\SupplierInvoiceController::class, 'destroy'])->name('supplier-invoices.destroy');


    //Supplier Orders routes
    Route::get('/supplier-orders', [App\Http\Controllers\SupplierOrderController::class, 'index'])->name('supplier-orders.index');
    Route::get('/supplier-orders/create', [App\Http\Controllers\SupplierOrderController::class, 'create'])->name('supplier-orders.create');
    Route::post('/supplier-orders', [App\Http\Controllers\SupplierOrderController::class, 'store'])->name('supplier-orders.store');
    Route::get('/supplier-orders/{supplierOrder}', [App\Http\Controllers\SupplierOrderController::class, 'show'])->name('supplier-orders.show');
    Route::get('/supplier-orders/{supplierOrder}/edit', [App\Http\Controllers\SupplierOrderController::class, 'edit'])->name('supplier-orders.edit');
    Route::put('/supplier-orders/{supplierOrder}', [App\Http\Controllers\SupplierOrderController::class, 'update'])->name('supplier-orders.update');
    Route::delete('/supplier-orders/{supplierOrder}', [App\Http\Controllers\SupplierOrderController::class, 'destroy'])->name('supplier-orders.destroy');
    Route::get('/supplier-orders/{supplierOrder}/pdf', [App\Http\Controllers\SupplierOrderController::class, 'pdf'])->name('supplier-orders.pdf');
    Route::post('/orders/{order}/convert-to-supplier-orders', [App\Http\Controllers\OrderController::class, 'convertToSupplierOrders'])->name('orders.convertToSupplierOrders');

    // Client Orders routes
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [App\Http\Controllers\OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [App\Http\Controllers\OrderController::class, 'edit'])->name('orders.edit');
    Route::get('/orders/{order}/pdf', [App\Http\Controllers\OrderController::class, 'pdf'])->name('orders.pdf');
    Route::put('/orders/{order}', [App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');

    // Proposals routes
    Route::get('/proposals', [App\Http\Controllers\ProposalController::class, 'index'])->name('proposals.index');
    Route::get('/proposals/create', [App\Http\Controllers\ProposalController::class, 'create'])->name('proposals.create');
    Route::post('/proposals', [App\Http\Controllers\ProposalController::class, 'store'])->name('proposals.store');
    Route::get('/proposals/{proposal}', [App\Http\Controllers\ProposalController::class, 'show'])->name('proposals.show');
    Route::get('/proposals/{proposal}/edit', [App\Http\Controllers\ProposalController::class, 'edit'])->name('proposals.edit');
    Route::put('/proposals/{proposal}', [App\Http\Controllers\ProposalController::class, 'update'])->name('proposals.update');
    Route::delete('/proposals/{proposal}', [App\Http\Controllers\ProposalController::class, 'destroy'])->name('proposals.destroy');
    Route::post('/proposals/{proposal}/convert-to-order', [App\Http\Controllers\ProposalController::class, 'convertToOrder'])->name('proposals.convertToOrder');
    Route::get('/proposals/{proposal}/pdf', [App\Http\Controllers\ProposalController::class, 'pdf'])->name('proposals.pdf');
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
