<?php

namespace OnrampLab\CloudCost\Services\Aws;

use Aws\CostExplorer\CostExplorerClient;
use Aws\Result;
use OnrampLab\CloudCost\DataTransferObjects\GetMonthlyAwsCostRequest;
use OnrampLab\CloudCost\DataTransferObjects\GetMonthlyAwsCostResponse;
use OnrampLab\CloudCost\Facades\AwsFacade as Aws;

class GetMonthlyAwsCostService
{
    public function perform(GetMonthlyAwsCostRequest $request): GetMonthlyAwsCostResponse
    {
        return $this->query($request);
    }

    private function query(GetMonthlyAwsCostRequest $request): GetMonthlyAwsCostResponse
    {
        /**
         * @var CostExplorerClient $client
         */
        $client = Aws::createClient('costExplorer');
        $result = $client->getCostAndUsage([
            'Filter' => $request->filter,
            'Metrics' => ['AmortizedCost'],
            'Granularity' => 'MONTHLY',
            'TimePeriod' => [
                'Start' => $request->date->format('Y-m-01'),
                'End' => $request->date->copy()->addMonth()->format('Y-m-01'),
            ],
        ]);

        return new GetMonthlyAwsCostResponse($result);
    }
}
