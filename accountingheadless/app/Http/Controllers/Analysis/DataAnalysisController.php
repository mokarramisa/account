<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Http\Resources\behaviorAnalysis\PaysResource;
use App\Models\Provience;
use App\Models\Transaction;
use App\Models\TransactionLog;
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
            $bestPays = Transaction::selectRaw('amount, count(*) as count')->transactionType('deposit')->groupBy('amount')->get();

            $bestProviences = Transaction::transactionType('deposit')->get()->groupBy('transactionLog.provience.provience_name')->map->count();
            //dd($bestProviences->prepend('', 'id'));
            // $bestProviences = Transaction::transactionType('deposit')->with('transactionLog.operator')->get();
            // dd($bestProviences);
            return [
                'bestPays' => PaysResource::collection($bestPays),
                //'bestProviences' => 
            ];
        }

        if (is_null($request->gateway_id)) {
            return [
                'bestPays' => '',  //a resource collectin
            ];
        }
    }
}
