<?php

namespace OnrampLab\CloudCost;

use Illuminate\Support\ServiceProvider;

class CloudCostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/package_template.php', 'package_template');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->offerPublishing();
    }

    public function offerPublishing(): void
    {
        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations'),
        ], 'laravel-cloud-cost-migration');

        $this->publishes([
            __DIR__ . '/../config/cloud-cost.php' => config_path('cloud-cost.php'),
        ], 'laravel-cloud-cost-config');
    }
}
