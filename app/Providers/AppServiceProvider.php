<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use App\Models\Company;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        // Partilhar dados da empresa globalmente (Blade e Inertia)
        View::share('company', Company::info());
        Inertia::share('company', fn() => Company::info());
    }
}
