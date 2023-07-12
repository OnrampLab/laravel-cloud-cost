<?php

namespace OnrampLab\CloudCost;

use Illuminate\Support\ServiceProvider;
use OnrampLab\CloudCost\Console;
use OnrampLab\CloudCost\Facades\AwsFacade;
use OnrampLab\CloudCost\Providers\AwsServiceProvider;

class CloudCostServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/package_template.php', 'package_template');

        $this->registerAws();
        $this->registerCommands();
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
            __DIR__ . '/../database/migrations/' => database_path('migrations'),
        ], 'laravel-cloud-cost-migration');

        $this->publishes([
            __DIR__ . '/../config/cloud-cost.php' => config_path('cloud-cost.php'),
        ], 'laravel-cloud-cost-config');
    }

    public function registerAws(): void
    {
        $this->app->register(AwsServiceProvider::class);
        $this->app->alias('aws', AwsFacade::class);
    }

    public function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\Sync::class,
            ]);
        }
    }
}
