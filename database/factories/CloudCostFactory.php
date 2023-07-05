<?php

namespace OnrampLab\CloudCost\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;

class CloudCostFactory extends Factory
{
    protected $model = CloudCost::class;

    public function definition(): array
    {
        return [
            'type'     => CloudCostType::AWS,
            'year'     => (int)$this->faker->year(),
            'month'    => (int)$this->faker->month(),
            'amount'   => $this->faker->randomFloat(null, 0, 100.999999),
            'currency' => CloudCostCurrency::USD,
        ];
    }
}
