<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function compareIncome ()
    {
        $yesterdayIncome = Transaction::transactionType('deposit')->whereBetween('created_at', [Carbon::now()->subDays(1), Carbon::now()->addDays(1)])->get();

        return $yesterdayIncome->sum('amount');
    }

}
