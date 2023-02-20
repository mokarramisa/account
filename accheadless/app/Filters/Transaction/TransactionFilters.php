<?php

namespace App\Filters\Transaction;

use App\Filters\AbstractFilter;

class TransactionFilters extends AbstractFilter
{
    protected $filters = [
        'timeline' => DatesFilter::class,
        'gateway'  => Gateway::class
    ];
}