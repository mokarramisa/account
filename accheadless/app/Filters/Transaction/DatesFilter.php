<?php

namespace App\Filters\Transaction;

use App\Services\Helpers\DateTimeHelper;
use Illuminate\Database\Eloquent\Builder;

class DatesFilter
{
    public function filter (Builder $builder, $value)
    {
        $timeline = [
            DateTimeHelper::LASTSEVENDAYS   => lastSevenDays(),
            DateTimeHelper::LASTWEEK        => lastWeek(),
            DateTimeHelper::LASTFIFTEENDAYS => lastFifteenDays(),
            DateTimeHelper::LASTTHIRTYDAYS  => lastThirtyDays(),
            DateTimeHelper::LASTMONTH       => lastMonth(),
            DateTimeHelper::LASTTHREEMONTH  => lastThreeMonth(),
            DateTimeHelper::LASTSIXMONTH    => lastSixMonth(),
            DateTimeHelper::LASTYEAR        => lastYear()
        ];

        return $builder->whereBetween('created_at', $timeline[$value]);
    }
}