<?php

namespace OnrampLab\CloudCost\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use OnrampLab\CloudCost\Enums\CloudCostType;
use OnrampLab\CloudCost\Models\CloudCost;

class CloudCostRepository
{
    public function get(int $id): CloudCost
    {
        return CloudCost::where('id', $id)->first();
    }

    public function findByTypeAndDate(CloudCostType $type, Carbon $date): ?CloudCost
    {
        return CloudCost::where('type', $type)
            ->where('date', $date->format('Y-m-d'))
            ->first();
    }

    public function findByDate(Carbon $date): Collection
    {
        return CloudCost::where('date', $date->format('Y-m-d'))
            ->get();
    }

    public function upsert(CloudCost $cloudCost): CloudCost
    {
        $existedCloudCost = $this->findByTypeAndDate($cloudCost->type, $cloudCost->date);
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
            'date' => $cloudCost->date,
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
