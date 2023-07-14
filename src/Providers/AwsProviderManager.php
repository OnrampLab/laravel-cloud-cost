<?php

namespace OnrampLab\CloudCost\Providers;

use Aws\Sdk;
use Illuminate\Contracts\Foundation\Application;
use InvalidArgumentException;
use OnrampLab\CloudCost\Contracts\AwsProviderManager as AwsProviderManagerContact;

class AwsProviderManager implements AwsProviderManagerContact
{
    private Application $app;
    private Sdk $sdk;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getSdk(): Sdk
    {
        if (!isset($this->sdk)) {
            $config = $this->getDriverConfig();
            $this->sdk = new Sdk([
                'access_key'    => $config['access_key'],
                'access_secret' => $config['access_secret'],
                'region'        => $config['region'],
                'version'       => $config['version'],
            ]);
        }
        return $this->sdk;
    }

    private function getDriverConfig(): array
    {
        $config = data_get($this->app, 'config.cloud-cost.driver.aws');
        if (!$config) {
            throw new InvalidArgumentException('config cloud-cost.driver.aws not found');
        }

        return $config;
    }
}
