<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Http\Resources\BehaviorAnalysis\FinantialReportsResource;
use App\Models\Transaction;
use App\Services\Helpers\DateTimeHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class FinantialReportsAnalysisController extends Controller
{


    public function __construct(private DateTimeHelper $dateHelper)
    {

    }
    public function reports (Request $request)
    {
        $from = $this->dateHelper->finantialPeriod();
        $to = $this->dateHelper->endOfThisMonth();

        $reports = Transaction::select('*')
                            ->filter($request) // is just for gate_way filter
                            ->whereBetween('created_at', [$from, $to])
                            ->get();

        $reportsCollection = $reports->groupBy(function($item) { 
            return $item->created_at->format('y-m'); 
            });
        
        return FinantialReportsResource::collection($reportsCollection);

        // foreach ($reportsCollection as $monthCollection) {

        //     $result[] = [
        //         'id' => "",
        //         'year' => $this->dateHelper->getJalaliYear(),
        //         'month' => $this->dateHelper->getJalaliMonth(),
        //         'deposit' => $monthCollection->where('transaction_type', 'deposit')->sum('amount'),
        //         'debit' => $monthCollection->where('transaction_type', 'withdraw')->sum('amount'),
        //         'wage' => $monthCollection->transactionType('deposit')->sum('wage')
        //     ];

        //     return $result;

        // }

        // if ($reportsCollection->isEmpty()) {
            
        //     for ($i=$to->format('m'); $i >= $from->format('m'); $i--) {
    
        //         $result[] = [
        //                 'id' => "",
        //                 'year' => jdate($to)->format('Y'),
        //                 'month' => jdate(($to->format('Y').'-'. $i . '-' . '01'))->format('%B'),
        //                 'deposit' => 0,
        //                 'debit' => 0,
        //                 'wage' => 0
        //             ];
        //     }
        //     return $result;
    
        // } else {
    
        //     for($i=$to->format('m'); $i >= $from->format('m'); $i--) {
        //         foreach ($reportsCollection as $collection => $value) { 
                        
        //             $result[] = [
        //                     'id' => "",
        //                     'year' => jdate($value[0]['date_time'])->format('Y'),
        //                     'month' => jdate((date('Y', strtotime($value[0]['date_time'])).'-'. $i . '-' . '01'))->format('%B'),
        //                     'deposit' => $value->where('month', $i)->transactionType('deposit')->sum('amount'),
        //                     'debit' => $value->where('month', $i)->transactionType('withdraw')->sum('amount'),
        //                     'wage' => $value->where('month', $i)->transactionType('deposit')->sum('wage')
        //                 ];
        //         }
        //     }
        //     return $result;    
        // }
    }
}
