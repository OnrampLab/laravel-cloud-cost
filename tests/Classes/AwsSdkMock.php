<?php

namespace OnrampLab\CloudCost\Tests\Classes;

use Aws\CostExplorer\CostExplorerClient;
use Aws\Result;
use Aws\Sdk;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Mockery;
use OnrampLab\CloudCost\Facades\AwsFacade;
use OnrampLab\CloudCost\Providers\AwsProviderManager;

final class AwsSdkMock
{
    public static function fake(): void
    {
        App::singleton('aws', function (Application $app) {

            $costExplorerClientMock = Mockery::mock(CostExplorerClient::class);
            $costExplorerClientMock
                ->shouldReceive('getCostAndUsage')
                ->andReturn(AwsSdkMockData::getCostAndUsage());

            $sdkMock = Mockery::mock(Sdk::class);
            $sdkMock->shouldReceive('createClient')
                ->with('costExplorer')
                ->andReturn($costExplorerClientMock);

            $providerMock = Mockery::mock(AwsProviderManager::class);
            $providerMock
                ->shouldReceive('getSdk')
                ->andReturn($sdkMock);

            return $providerMock;
        });
    }
}

final class AwsSdkMockData
{
    public static function getCostAndUsage(): Result
    {
        $result = [
            'ResultsByTime' => [
                [
                    'TimePeriod' => [
                        'Start' => '2023-06-01',
                        'End' => '2023-07-01',
                    ],
                    'Total' => [
                        'AmortizedCost' => [
                            'Amount' => '100',
                            'Unit' => 'USD',
                        ],
                    ],
                    'Groups' => [],
                    'Estimated' => false,
                ],
            ],
            'DimensionValueAttributes' => [],
            '@metadata' => [
                'statusCode' => 200,
                'effectiveUri' => 'https://ce.us-east-1.amazonaws.com',
                'headers' => [
                    'date' => 'Thu, 06 Jul 2023 07:45:23 GMT',
                    'content-type' => 'application/x-amz-json-1.1',
                    'content-length' => '190',
                    'connection' => 'keep-alive',
                    'x-amzn-requestid' => 'eeeeeeee-6666-4444-8888-444444444444',
                    'cache-control' => 'no-cache',
                ],
                'transferStats' => [
                    'http' => [[]],
                ],
            ],
        ];
        return new Result($result);
    }
}
