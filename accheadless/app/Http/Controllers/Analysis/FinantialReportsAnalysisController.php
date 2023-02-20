<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class FinantialReportsAnalysisController extends Controller
{
    public function reports (Request $request)
    {
        $to = Jalalian::fromFormat('Y-m-d', jdate('next month')->format('Y-m-01'))->toCarbon();
        $five_month_before = Jalalian::fromFormat('Y-m-d', jdate()->subMonths('4')->format('Y-m-01'))->toCarbon();
        $start_of_year = Jalalian::fromFormat('Y-m-d' ,jdate()->format('Y-01-01'))->toCarbon();

        //اختلاف ماه فعلی از 5 ماه قبل محاسبه می‌شود اگر منفی بود از ابتدای سال آغاز می‌کنیم.
        $diff = strtotime($five_month_before) - strtotime($start_of_year);
        $from = ($diff < 0) ? $start_of_year : $five_month_before;

        $reports = Transaction::select('*')
                            ->filter($request)
                            ->whereBetween('created_at', [$from, $to])
                            ->get();

        $reportsCollection = $reports->groupBy('created_at');
        dd($reportsCollection);

        if ($reportsCollection->isEmpty()) {
            
            for ($i=$to->format('m'); $i >= $from->format('m'); $i--) {
    
                $result[] = [
                        'id' => "",
                        'year' => jdate($to)->format('Y'),
                        'month' => jdate(($to->format('Y').'-'. $i . '-' . '01'))->format('%B'),
                        'deposit' => 0,
                        'debit' => 0,
                        'wage' => 0
                    ];
            }
            return $result;
    
        } else {
    
            for($i=$to->format('m'); $i >= $from->format('m'); $i--) {
                foreach ($reportsCollection as $collection => $value) { 
                        
                    $result[] = [
                            'id' => "",
                            'year' => jdate($value[0]['date_time'])->format('Y'),
                            'month' => jdate((date('Y', strtotime($value[0]['date_time'])).'-'. $i . '-' . '01'))->format('%B'),
                            'deposit' => $value->where('month', $i)->transactionType('deposit')->sum('amount'),
                            'debit' => $value->where('month', $i)->transactionType('withdraw')->sum('amount'),
                            'wage' => $value->where('month', $i)->transactionType('deposit')->sum('wage')
                        ];
                }
            }
            return $result;    
        }
    }
}
