<?php

namespace App\Filters\Transaction;

use Illuminate\Database\Eloquent\Builder;

class Gateway
{
    public function filter (Builder $builder, $value)
    {
        return $builder->where('gateway_id', $value);
    }
}