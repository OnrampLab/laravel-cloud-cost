<?php

namespace OnrampLab\CloudCost\Services;

use Carbon\Carbon;
use OnrampLab\CloudCost\DataTransferObjects\GetMonthlyAwsCostRequest;
use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;
use OnrampLab\CloudCost\Repositories\CloudCostRepository;
use OnrampLab\CloudCost\Services\Aws\GetMonthlyAwsCostService;

class SyncAwsCostService
{
    public function __construct(
        private readonly CloudCostRepository $cloudCostRepository,
        private readonly GetMonthlyAwsCostService $getMonthlyAwsCostService)
    {
    }

    public function perform(array $filter, int $year, $month): void
    {
        $date = Carbon::createFromDate($year, $month, 1);
        $request = new GetMonthlyAwsCostRequest([
            'filter' => $filter,
            'date' => $date,
        ]);
        $response = $this->getMonthlyAwsCostService->perform($request);

        $cloudCost = new CloudCost([
            'type' => CloudCostType::AWS,
            'currency' => CloudCostCurrency::from($response->currency),
            'amount' => $response->amount,
            'year' => $request->date->year,
            'month' => $request->date->month,
        ]);
        $this->cloudCostRepository->upsert($cloudCost);
    }
}
