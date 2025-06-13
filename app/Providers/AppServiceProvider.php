<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
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
        //
        Carbon::macro('displayFormat', function () {
            return $this->format('d/m/Y');
        });

        // Ou pour toute l'application
        config(['app.date_format' => 'd/m/Y']);
    }
}
