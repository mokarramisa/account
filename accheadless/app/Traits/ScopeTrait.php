<?php

namespace App\Traits;

use Morilog\Jalali\Jalalian;

trait ScopeTrait {

    protected function scopelastSevenDays ($query, $timeline)
    {

        dd("ok");
    }

    protected function scopeLastWeek ($query)
    {
        $day = Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-d'))->toCarbon()->format('l');

        if ($day == 'Saturday') {
            
            $timeline = [
                Jalalian::fromFormat('Y-m-d', jdate()->subDays(7)->format('Y-m-d'))->toCarbon(),
                Jalalian::fromFormat('Y-m-d', jdate()->subDays(1)->format('Y-m-d'))->toCarbon()
            ];

            return $query->whereBetween('created_at', $timeline);
        } 
        
        if ($day == 'Sunday') {

            $timeline = [
                Jalalian::fromFormat('Y-m-d', jdate()->subDays(8)->format('Y-m-d'))->toCarbon(),
                Jalalian::fromFormat('Y-m-d', jdate()->subDays(2)->format('Y-m-d'))->toCarbon()
            ];

            return $query->whereBetween('created_at', $timeline);

        } else {

            $timeline = [
                Jalalian::fromFormat('Y-m-d', jdate('last week')->subDays(2)->format('Y-m-d'))->toCarbon(),
                Jalalian::fromFormat('Y-m-d', jdate('last week')->addDays(4)->format('Y-m-d'))->toCarbon()
            ];

            return $query->whereBetween('created_at', $timeline);
        }
    }

    public function scopeThisWeek ($query)
    {
        $day = Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-d'))->toCarbon()->format('l');

        if ($day == 'Saturday') {
            
            $timeline = [
                Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-d'))->toCarbon(),
                Jalalian::fromFormat('Y-m-d', jdate()->addDays(6)->format('Y-m-d'))->toCarbon()
            ];

            return $query->whereBetween('created_at', $timeline);

        } elseif ($day == 'Sunday') {

            $timeline = [
                Jalalian::fromFormat('Y-m-d', jdate()->subDays(1)->format('Y-m-d'))->toCarbon(),
                Jalalian::fromFormat('Y-m-d', jdate()->addDays(7)->format('Y-m-d'))->toCarbon()
            ];

            return $query->whereBetween('created_at', $timeline);

        } else {

            $timeline = [
                Jalalian::fromFormat('Y-m-d', jdate('this week')->subDays(2)->format('Y-m-d'))->toCarbon(),
                Jalalian::fromFormat('Y-m-d', jdate('this week')->addDays(4)->format('Y-m-d'))->toCarbon()   
            ];

            return $query->whereBetween('created_at', $timeline);
        }
    }

    public function scopeThisMonth ()
    {
        $timeline = [
            Jalalian::fromFormat('Y-m-d', jdate('this month')->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('next month')->format('Y-m-01'))->toCarbon()->subDay(1)
        ];

        return $query->whereBetween('created_at', $timeline);
    }

    // ???????????? ?????? ?????????? ???????? ???????? ?? ???? ?????? ?????? ???? ???????????? ?????? ?????????? ???????????? ?????? ?????????? ???? ???????? ?????????????.
    public function scopeLastMonth ()
    {
        $timeline = [
            Jalalian::fromFormat('Y-m-d', jdate('last month')->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('this month')->format('Y-m-01'))->toCarbon()->subDays(1)
        ];

        return $query->whereBetween('created_at', $timeline);
    }

    //???????????? ???? ?????? ?????????? ???????? ???????? ?? ???? ?????? ?????? ???? ???????????? ?????? ?????????? ???????????? ?????? ?????????? ???? ???????? ?????????????.
    public function scopeLastThreeMonth ()
    {
        $timeline = [
            Jalalian::fromFormat('Y-m-d', jdate()->subMonths(3)->format('Y-m-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-01'))->toCarbon()->subDays(1)
        ];

        return $query->whereBetween('created_at', $timeline);
    }

    //???????????? ???? ?????? ?????????? ???????? ???????? ?? ???? ?????? ?????? ???? ???????????? ?????? ?????????? ???????????? ?????? ?????????? ???? ???????? ?????????????.
    public function scopeLastSixMonth ()
    {
        $timeline = [
            (Jalalian::fromFormat('Y-m-d', jdate()->subMonths(6)->format('Y-m-01')))->toCarbon(),
            (Jalalian::fromFormat('Y-m-d', jdate()->format('Y-m-01')))->toCarbon()->subDay(1)
        ];

        return $query->whereBetween('created_at', $timeline);
    }

    //???????????? ?????? ?????????? ???????? ???????? ?? ???? ?????? ?????? ???? ???????????? ?????? ?????????? ???????????? ?????? ?????????? ???? ???????? ?????????????.
    public function scopeLastYear ()
    {
        $timeline = [
            Jalalian::fromFormat('Y-m-d', jdate('last year')->format('Y-01-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('this year')->format('Y-01-01'))->toCarbon()->subDays(1)
        ];

        return $query->whereBetween('created_at', $timeline);
    }

    //???????????? ?????????? ???????? ???????? ?? ???? ?????? ?????? ???? ???????????? ?????? ???????????? ???????????? ?????????? ???? ???????? ?????????????.
    public function scopeThisYear ()
    {
        $timeline = [
            Jalalian::fromFormat('Y-m-d', jdate('this year')->format('Y-01-01'))->toCarbon(),
            Jalalian::fromFormat('Y-m-d', jdate('next year')->format('Y-01-01'))->toCarbon()->subDays(1)
        ];

        return $query->whereBetween('created_at', $timeline);
    }

}