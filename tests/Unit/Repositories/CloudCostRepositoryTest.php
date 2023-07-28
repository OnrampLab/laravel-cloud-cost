<?php

namespace OnrampLab\CloudCost\Tests\Unit\Repositories;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;
use OnrampLab\CloudCost\Repositories\CloudCostRepository;
use OnrampLab\CloudCost\Tests\TestCase;

class CloudCostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CloudCostRepository $cloudCostRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cloudCostRepository = app(CloudCostRepository::class);
    }

    /**
     * @test
     */
    public function should_get(): void
    {
        $cloudCost = CloudCost::factory()->create();
        $expectedCloudCost = $this->cloudCostRepository->get($cloudCost->id);

        $this->assertEquals($expectedCloudCost->toArray(), $cloudCost->toArray());
    }

    /**
     * @test
     */
    public function should_upsert(): void
    {
        $cloudCost = new CloudCost([
            'type' => CloudCostType::AWS,
            'date' => Carbon::create(2023, 1, 1),
            'amount' => 12.50,
            'currency' => CloudCostCurrency::USD,
        ]);
        $this->assertEquals(null, $cloudCost->id);

        $createCloudCost = $this->cloudCostRepository->upsert($cloudCost);
        $this->assertEquals($createCloudCost->type, $cloudCost->type);
        $this->assertEquals($createCloudCost->amount, $cloudCost->amount);
        $this->assertNotNull($createCloudCost->id);

        $createCloudCost->amount = 18.90;
        $updateCloudCost = $this->cloudCostRepository->upsert(Clone $createCloudCost);

        $this->assertEquals(18.90, $updateCloudCost->amount);
        $this->assertEquals($createCloudCost->created_at, $updateCloudCost->created_at);
        $this->assertEquals($updateCloudCost->id, $createCloudCost->id);
    }
}
