<?php

namespace OnrampLab\CloudCost\Services\Aws;

use Aws\CostExplorer\CostExplorerClient;
use OnrampLab\CloudCost\DataTransferObjects\GetDailyAwsCostRequest;
use OnrampLab\CloudCost\DataTransferObjects\GetDailyAwsCostResponse;

class GetDailyAwsCostService
{
    public function perform(GetDailyAwsCostRequest $request): GetDailyAwsCostResponse
    {
        return $this->query($request);
    }

    private function query(GetDailyAwsCostRequest $request): GetDailyAwsCostResponse
    {
        /**
         * @var CostExplorerClient $client
         */
        $client = app('aws')->getSdk()->createClient('costExplorer');
        $result = $client->getCostAndUsage([
            'Filter' => $request->filter,
            'Metrics' => ['AmortizedCost'],
            'Granularity' => 'DAILY',
            'TimePeriod' => [
                'Start' => $request->date->format('Y-m-d'),
                'End' => $request->date->copy()->addDay()->format('Y-m-d'),
            ],
        ]);

        return new GetDailyAwsCostResponse($result);
    }
}
