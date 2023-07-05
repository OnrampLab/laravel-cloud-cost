<?php

namespace OnrampLab\CloudCost\Tests\Unit\Models;

use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;
use OnrampLab\CloudCost\Tests\TestCase;

class CloudCostTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function enum_cast_should_work(): void
    {
        $cloudCost = new CloudCost([
            'type' => CloudCostType::AWS,
            'currency' => CloudCostCurrency::USD,
        ]);

        $this->assertEquals(CloudCostType::AWS, $cloudCost->type);
        $this->assertEquals(CloudCostCurrency::USD, $cloudCost->currency);
    }
}
