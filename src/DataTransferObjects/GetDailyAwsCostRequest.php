<?php

namespace OnrampLab\CloudCost\DataTransferObjects;

use Carbon\Carbon;

class GetDailyAwsCostRequest
{
    public readonly array $filter;
    public readonly Carbon $date;

    public function __construct(array $data)
    {
        $this->filter = $data['filter'];
        $this->date = $data['date'];
    }
}
