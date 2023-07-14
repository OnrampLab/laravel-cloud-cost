<?php

namespace OnrampLab\CloudCost\DataTransferObjects;

use Aws\Result;

class GetMonthlyAwsCostResponse
{
    public readonly float $amount;
    public readonly string $currency;

    public function __construct(Result $awsResult)
    {
        $result = $awsResult->toArray();
        $this->amount = (float) data_get($result, "ResultsByTime.0.Total.AmortizedCost.Amount", 0);
        $this->currency = (string) data_get($result, "ResultsByTime.0.Total.AmortizedCost.Unit" );
    }
}
