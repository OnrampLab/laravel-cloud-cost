<?php

namespace OnrampLab\CloudCost\Services;

use Carbon\Carbon;
use OnrampLab\CloudCost\DataTransferObjects\GetDailyAwsCostRequest;
use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;
use OnrampLab\CloudCost\Repositories\CloudCostRepository;
use OnrampLab\CloudCost\Services\Aws\GetDailyAwsCostService;

class SyncAwsCostService
{
    public function __construct(
        private readonly CloudCostRepository $cloudCostRepository,
        private readonly GetDailyAwsCostService $getDailyAwsCostService)
    {
    }

    public function perform(array $filter, int $year, int $month, int $day): void
    {
        $date = Carbon::createFromDate($year, $month, $day);
        $request = new GetDailyAwsCostRequest([
            'filter' => $filter,
            'date' => $date,
        ]);
        $response = $this->getDailyAwsCostService->perform($request);

        $cloudCost = new CloudCost([
            'type' => CloudCostType::AWS,
            'currency' => CloudCostCurrency::from($response->currency),
            'amount' => $response->amount,
            'date' => $request->date,
        ]);
        $this->cloudCostRepository->upsert($cloudCost);
    }
}
