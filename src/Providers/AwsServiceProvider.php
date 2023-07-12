<?php

namespace OnrampLab\CloudCost\Providers;

use Aws\Sdk;
use Illuminate\Support\ServiceProvider;

/**
 * AWS SDK for PHP service provider for Laravel applications
 */
class AwsServiceProvider extends ServiceProvider
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function register(): void
    {
        $this->app->singleton('aws', function ($app) {
            $config = $app->make('config')->get('cloud-cost.driver.aws');
            return new Sdk($config);
        });
    }

    public function boot(): void
    {
    }
}
