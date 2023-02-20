<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Morilog\Jalali\Jalalian;

if (! function_exists('lastSevenDays')) {

    function lastSevenDays ()
    {
        $from = Carbon::now()->subDays(7);
        $to = Carbon::now();

        return [$from, $to];
    }
}

if (! function_exists('lastFifteenDays')) {

    function lastFifteenDays ()
    {
        $startDate = Carbon::now()->subDays(15);
        $endDate = Carbon::now();

        return [$startDate, $endDate];
    }
}

if (! function_exists('lastThirtyDays')) {
    function lastThirtyDays ()
    {
        $from = Carbon::now()->subDays(30);
        $to = Carbon::now();

        return [$from, $to];
    }
}

if (! function_exists('thisWeek')) {
    function thisWeek ()
    {
        $fars = CarbonImmutable::now()->locale('fa');
        return [$fars->startOfWeek(Carbon::SATURDAY), $fars->endOfWeek(Carbon::FRIDAY)];
    }
}

if (! function_exists('lastWeek')) {
    function lastWeek ()
    {
        $fars = CarbonImmutable::now()->locale('fa');
        return [$fars->startOfWeek(Carbon::SATURDAY)->subWeek(), $fars->endOfWeek(Carbon::FRIDAY)->subWeek()];
    }
}

if (! function_exists('thisMonth')) {
    function thisMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('this month')->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('next month')->format('Y-m-01'))->toCarbon()->subDay(1)
        ];
    }
}

if (! function_exists('lastMonth')) {
    function lastMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('last month')->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('this month')->format('Y-m-01'))->toCarbon()->subDays(1)
        ];
    }
}

if (! function_exists('lastThreeMonth')) {
    function lastThreeMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate()->subMonths(3)->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-01'))->toCarbon()->subDays(1)
        ];
    }
}

if (! function_exists('lastSixMonth')) {
    function lastSixMonth ()
    {
        return [
            (Jalalian::fromFormat('Y-m-d', jdate()->subMonths(6)->format('Y-m-01')))->toCarbon(),
            (Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-01')))->toCarbon()->subDay(1)
        ];
    }
}

if (! function_exists('lastYear')) {
    function lastYear ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('last year')->format('Y-01-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('this year')->format('Y-01-01'))->toCarbon()->subDays(1)
        ];
    }
}

if (! function_exists('thisYear')) {
    function thisYear ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('this year')->format('Y-01-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('next year')->format('Y-01-01'))->toCarbon()->subDays(1)
        ];
    }
}
    
    
    
