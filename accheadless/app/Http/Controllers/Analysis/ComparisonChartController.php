<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Services\Helpers\DateTimeHelper;
use Illuminate\Http\Request;

class ComparisonChartController extends Controller
{
    public function compare (Request $request)
    {
        $result['paymentReports'] = [];
        $result['transactionReports'] = [];

        $timeline = $request->timeline;
        $dates = DateTimeHelper::DATES;
        $numberOfDays = array_key_exists($request->timeline, $dates) ? $dates[$timeline]['numreic-dates'] : 0;
        $deposit = Transaction::select('amount', 'created_at', 'gateway_id')->filter($request)->transactionType('deposit')->get();


        $paymentAmount = $deposit->groupBy(function($item) { 
            return $item->created_at->format('y-m-d'); 
            })->map(function($raw) {
                return $raw->sum('amount');
        });

        $paymentCount = $deposit->groupBy(function($item) { 
            return $item->created_at->format('y-m-d'); 
            })->map(function($raw) {
                return $raw->count('amount');
        });
    
        $result = getpaymentAxis($paymentAmount, $result, $numberOfDays);
        $result = getAxis($paymentCount, $result, $numberOfDays);

        return $result;
    }
}
