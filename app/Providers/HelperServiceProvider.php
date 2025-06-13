<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
  public function register()
{
    foreach (glob(app_path('helper') . '/*.php') as $file) {
        require_once $file;
    }
}

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
