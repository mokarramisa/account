<?php

namespace App\Services\Helpers;

use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;

class DateTimeHelper 
{
    public function getJalaliYear()
    {
        $dateParts = explode('-', (Carbon::now())->toDateString());
        $persianDate = CalendarUtils::toJalali($dateParts[0], $dateParts[1], $dateParts[2]);
        return $persianDate[0];
    }

    public function getJalaliMonth()
    {
        $dateParts = explode('-', (Carbon::now())->toDateString());
        $persianDate = CalendarUtils::toJalali($dateParts[0], $dateParts[1], $dateParts[2]);
        return in_array($persianDate[1], [10, 11, 12]) ? $persianDate[1] : '0' . $persianDate[1];
    }

    public function getJalaliDay()
    {
        $dateParts = explode('-', (Carbon::now())->toDateString());
        $persianDate = CalendarUtils::toJalali($dateParts[0], $dateParts[1], $dateParts[2]);
        return $persianDate[2];
    }
}