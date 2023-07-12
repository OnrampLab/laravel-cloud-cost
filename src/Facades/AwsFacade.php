<?php

namespace OnrampLab\CloudCost\Facades;

use Aws\AwsClientInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Facade for the AWS service
 *
 * @method static AwsClientInterface createClient($name, array $args = []) Get a client from the service builder.
 */
class AwsFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'aws';
    }
}
