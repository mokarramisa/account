<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataAnalysisController extends Controller
{
    public function analysis (Request $request, Transaction $transaction)
    {
        // gateway_id and timeline should be on request payload
        $payload = $request->payload;
        $timeLine = [
            $transaction::LAST_SEVEN_DAYS,
            $transaction::LAST_WEEK,
            $transaction::LAST_THIRTY_DAYS,
            $transaction::LAST_MONTH,
            $transaction::LAST_THREE_MONTH,
            $transaction::LAST_SIX_MONTH,
            $transaction::LAST_YEAR,
        ];

        if (is_null($payload)) {
            $bestPays = Transaction::select('amount', 'count(*) as count')->transactionType('deposit')->groupBy('amount')->get();
            dd($bestPays);
            // return [
            //     'bestPays' => 
            // ];
        }

        if (is_null($request->gateway_id)) {
            return [
                'bestPays' => '',  //a resource collectin
            ];
        }
    }
}
