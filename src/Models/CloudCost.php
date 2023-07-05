<?php

namespace OnrampLab\CloudCost\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use OnrampLab\CloudCost\Database\Factories\CloudCostFactory;
use OnrampLab\CloudCost\Enums\CloudCostCurrency;
use OnrampLab\CloudCost\Enums\CloudCostType;

/**
 * @property int $id
 * @property CloudCostType $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property int $year
 * @property int $month
 * @property float $amount
 * @property CloudCostCurrency $currency
 * @mixin Builder
 */
class CloudCost extends Model
{
    use HasFactory;

    /**
     * @var array<string>
     */
    protected $fillable = [
        'type',
        'created_at',
        'updated_at',
        'year',
        'month',
        'amount',
        'currency',
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'type' => CloudCostType::class,
        'currency' => CloudCostCurrency::class,
    ];

    public static function newFactory(): Factory
    {
        return CloudCostFactory::new();
    }
}
