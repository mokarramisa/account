<?php

use Carbon\Carbon;

function getAxis ($collection, $result, $numberOfdays)
{
    for ($i=$numberOfdays-1; $i >= 0 ; $i--) { 
            
        $x = date('Y-m-d', strtotime('-'.$i.'days'));
        $jalali = jdate($x)->format('Y/m/d');

        if ($collection->isEmpty()) {

            array_push($result['transactionReports'],
                [
                    'id' => "",
                    'date' => $jalali,
                    'value' => 0
                ]);

        } else {

            foreach ($collection as $key => $value) {
                if (Carbon::parse($key)->format('Y-m-d') == $x) {
                    array_push($result['transactionReports'], 
                    [
                        'id' => "",
                        'date' => $jalali,
                        'value' => $value
                    ]);
                }
            }
        }

        if (!in_array( $jalali, array_column($result['transactionReports'], 'date'))) {

            array_push($result['transactionReports'],
                    [
                        'id' => "",
                        'date' => $jalali,
                        'value' => 0
                    ]);
        }
    }
    return $result;
    }

function getpaymentAxis ($collection, $result, $numberOfdays)
{
    for ($i=$numberOfdays-1; $i >= 0 ; $i--) { 
        $x = date('Y-m-d', strtotime('-'.$i.'days'));
        $jalali = jdate($x)->format('Y/m/d');

        if ($collection->isEmpty()) {
            array_push($result['paymentReports'],
                [
                    'id' => "",
                    'date' => $jalali,
                    'value' => 0
                ]);

        } else {    
            foreach ($collection as $key => $value) {
                if (Carbon::parse($key)->format('Y-m-d') == $x) {
                    array_push($result['paymentReports'], 
                    [
                        'id' => "",
                        'date' => $jalali,
                        'value' => $value
                    ]);
                } 
            }        
        }
        if (!in_array($jalali, array_column($result['paymentReports'], 'date'))) {

            array_push($result['paymentReports'],
                    [
                        'id' => "",
                        'date' => $jalali,
                        'value' => 0
                    ]);
        }
    }
    return $result;
}