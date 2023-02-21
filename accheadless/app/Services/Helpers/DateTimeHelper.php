<?php

namespace App\Services\Helpers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class DateTimeHelper 
{
    const LASTSEVENDAYS = 'last-seven-days';
    const LASTWEEK = 'last-week';
    const LASTFIFTEENDAYS = 'last-fifteen-days';
    const LASTTHIRTYDAYS = 'last-thirty-days';
    const LASTMONTH = 'last-month';
    const LASTTHREEMONTH = 'last-three-month';
    const LASTSIXMONTH = 'last-six-month';
    const LASTYEAR = 'last-year';

    const DATES = [
        self::LASTSEVENDAYS => [
            'value' => self::LASTSEVENDAYS,
            'fa-dates' => 'هفت روز گذشته',
            'numreic-dates' => '7'
        ],
        self::LASTWEEK => [
            'value' => self::LASTWEEK,
            'fa-dates' => 'هفته گذشته',
            'numreic-dates' => '7'
        ],
        self::LASTFIFTEENDAYS => [
            'value' => self::LASTFIFTEENDAYS,
            'fa-dates' => 'پانزده روز گذشته',
            'numreic-dates' => '15'
        ],
        self::LASTTHIRTYDAYS => [
            'value' => self::LASTTHIRTYDAYS,
            'fa-dates' => 'سی روز گذشته',
            'numreic-dates' => '30'
        ],
        self::LASTMONTH => [
            'value' => self::LASTMONTH,
            'fa-dates' => 'ماه گذشته',
            'numreic-dates' => '30'
        ],
        self::LASTTHREEMONTH => [
            'value' => self::LASTTHREEMONTH,
            'fa-dates' => 'سه ماه گذشته',
            'numreic-dates' => '90'
        ],
        self::LASTSIXMONTH => [
            'value' => self::LASTSIXMONTH,
            'fa-dates' => 'شش ماه گذشته',
            'numreic-dates' => '18'
        ],
        self::LASTYEAR => [
            'value' => self::LASTYEAR,
            'fa-dates' => 'سال گذشته',
            'numreic-dates' => '365'
        ]
    ];

    protected $fars;

    public function __construct()
    {
        $this->fars = CarbonImmutable::now()->locale('fa');
    }

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

    public function endOfThisMonth ()
    {
        return (Jalalian::forge('next month')->subDays(1))->toCarbon();
    }

    public function finantialPeriod ()
    {
        $five_month_before = Jalalian::fromFormat('Y-m-d', jdate()->subMonths('4')->format('Y-m-01'))->toCarbon();
        $start_of_year = Jalalian::fromFormat('Y-m-d' ,jdate()->format('Y-01-01'))->toCarbon();

        //اختلاف ماه فعلی از 5 ماه قبل محاسبه می‌شود اگر منفی بود از ابتدای سال آغاز می‌کنیم.
        $diff = strtotime($five_month_before) - strtotime($start_of_year);
        $from = ($diff < 0) ? $start_of_year : $five_month_before;

        return $from;
    }

    public function getEndOfMonth(Carbon $dt = null) 
    {
        Jalalian::forge('next month');

        return [$this->getJalaliYear(), $this->getJalaliMonth()];
    }

    public static function lastSevenDays ()
    {
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        return [$startDate, $endDate];
    }

    public static function lastFifteenDays ()
    {
        $startDate = Carbon::now()->subDays(15);
        $endDate = Carbon::now();

        return [$startDate, $endDate];
    }

    public static function lastThirtyDays ()
    {
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();

        return [$startDate, $endDate];
    }

    public function thisWeek ()
    {
        return [
            $this->fars->startOfWeek(Carbon::SATURDAY),
            $this->fars->endOfWeek(Carbon::FRIDAY)
        ];
    }

    public function lastWeek ()
    {
        return [
            $this->fars->startOfWeek(Carbon::SATURDAY)->subWeek(), 
            $this->fars->endOfWeek(Carbon::FRIDAY)->subWeek()
        ];
    }

    public static function thisMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('this month')->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('next month')->format('Y-m-01'))->toCarbon()->subDay(1)
        ];
    }

    public static function lastMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('last month')->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('this month')->format('Y-m-01'))->toCarbon()->subDays(1)
        ];
    }

    public static function lastThreeMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate()->subMonths(3)->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-01'))->toCarbon()->subDays(1)
        ];
    }

    public static function lastSixMonth ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate()->subMonths(6)->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-01'))->toCarbon()->subDay(1)
        ];
    }

    public static function lastYear ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('last year')->format('Y-01-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('this year')->format('Y-01-01'))->toCarbon()->subDays(1)
        ];
    }

    public static function thisYear ()
    {
        return [
            Jalalian::fromFormat('Y-m-d', jdate('this year')->format('Y-01-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('next year')->format('Y-01-01'))->toCarbon()->subDays(1)
        ];
    }
}