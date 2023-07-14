<?php

namespace OnrampLab\CloudCost\Tests\Unit\Services;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OnrampLab\CloudCost\DataTransferObjects\GetMonthlyAwsCostRequest;
use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;
use OnrampLab\CloudCost\Repositories\CloudCostRepository;
use OnrampLab\CloudCost\Services\Aws\GetMonthlyAwsCostService;
use OnrampLab\CloudCost\Tests\Classes\AwsSdkMock;
use OnrampLab\CloudCost\Tests\TestCase;

final class GetMonthlyAwsCostServiceTest extends TestCase
{
    use RefreshDatabase;

    private CloudCostRepository $cloudCostRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cloudCostRepository = app(CloudCostRepository::class);
    }

    /**
     * @test perform()
     */
    public function should_work(): void
    {
        AwsSdkMock::fake();

        $date = Carbon::now();
        $filter = [
            'Tags' => [
                'Key' => 'Project',
                'Values' => ['YourProjectName', 'your-project-name'],
            ],
        ];

        /**
         * @var GetMonthlyAwsCostService $getMonthlyAwsCostService
         */
        $getMonthlyAwsCostService = app(GetMonthlyAwsCostService::class);
        $param = new GetMonthlyAwsCostRequest([
            'filter' => $filter,
            'date' => $date,
        ]);

        $result = $getMonthlyAwsCostService->perform($param);

        $createCloudCost = new CloudCost([
            'type' => CloudCostType::AWS,
            'amount' => $result->amount,
            'year' => 2023,
            'month' => 1,
            'currency' => CloudCostCurrency::from($result->currency),
        ]);
        $cloudCost = $this->cloudCostRepository->upsert($createCloudCost);

        $this->assertEquals(2023, $cloudCost->year);
        $this->assertEquals(1, $cloudCost->month);
        $this->assertEquals($result->amount, $cloudCost->amount);
        $this->assertEquals($result->currency, $cloudCost->currency->value);
    }
}
