<?php

namespace OnrampLab\CloudCost\Repositories;

use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;

class CloudCostRepository
{
    public function get(int $id): CloudCost
    {
        return CloudCost::where('id', $id)->first();
    }

    public function findByTypeAndDate(CloudCostType $type, int $year, int $month): ?CloudCost
    {
        return CloudCost::where('type', $type)
            ->where('year', $year)
            ->where('month', $month)
            ->first();
    }

    public function upsert(CloudCost $cloudCost): CloudCost
    {
        $existedCloudCost = $this->findByTypeAndDate($cloudCost->type, $cloudCost->year, $cloudCost->month);
        if ($existedCloudCost) {
            $existedCloudCost->amount = $cloudCost->amount;
            $existedCloudCost->currency = $cloudCost->currency;
            return $this->update($existedCloudCost);
        } else {
            return $this->create($cloudCost);
        }
    }

    private function create(CloudCost $cloudCost): CloudCost
    {
        return CloudCost::create([
            'type' => $cloudCost->type,
            'year' => $cloudCost->year,
            'month' => $cloudCost->month,
            'amount' => $cloudCost->amount,
            'currency' => $cloudCost->currency,
        ]);
    }

    private function update(CloudCost $cloudCost): CloudCost
    {
        $cloudCost->update([
            'amount' => $cloudCost->amount,
            'currency' => $cloudCost->currency,
        ]);

        return $cloudCost;
    }
}
