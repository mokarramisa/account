<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Http\Resources\BehaviorAnalysis\TopBrowsersResource;
use App\Http\Resources\BehaviorAnalysis\TopDevicesResource;
use App\Http\Resources\BehaviorAnalysis\TopOperatorsResource;
use App\Http\Resources\BehaviorAnalysis\TopOsResource;
use App\Http\Resources\BehaviorAnalysis\TopPaysResource;
use App\Http\Resources\BehaviorAnalysis\TopProviencesResource;
use App\Models\Browser;
use App\Models\Device;
use App\Models\OperatingSystem;
use App\Models\Operator;
use App\Models\Provience;
use App\Models\Transaction;
use App\Services\Analysis\Repository;
use Illuminate\Http\Request;

class DataAnalysisController extends Controller
{
    // gateway_id and timeline should be on request payload
    // request in the payload should be: timeline and gateway_id or one of them or nothing
    public function analysis (Request $request)
    {
        $topPays = Transaction::selectRaw('amount, count(*) as count')->filter($request)->transactionType('deposit')->groupBy('amount')->get();
        $topProviences = Repository::getTop(Provience::query(), 'transactionLogs')->filter($request)->orderBy('transaction_logs_count', 'desc')->get(5);
        $topOperators = Repository::getTop(Operator::query(), 'transactionLogs')->filter($request)->orderBy('transaction_logs_count')->get(5);

        $topBrowsers = Repository::getTop(Browser::query(), 'transactionLogs')->filter($request)->orderBy('transaction_logs_count')->get(5);
        $topOperatingSystems = Repository::getTop(OperatingSystem::query(), 'transactionLogs')->filter($request)->orderBy('transaction_logs_count')->get(5);
        $topDevices = Repository::getTop(Device::query(), 'transactionLogs')->filter($request)->orderBy('transaction_logs_count')->get(5);

        $newPayer = Transaction::transactionType('deposit')->filter($request)->cardNumber()->having('counts', '=', 1)->count();
        $loyalPayer = Transaction::transactionType('deposit')->filter($request)->cardNumber()->having('counts', '>=', 2)->count();

        return [
            'topPays'             => TopPaysResource::collection($topPays),
            'topProviences'       => TopProviencesResource::collection($topProviences),
            'bestOperator'        => TopOperatorsResource::collection($topOperators),
            'topBrowsers'         => TopBrowsersResource::collection($topBrowsers),
            'topDevices'          => TopDevicesResource::collection($topDevices),
            'topOperatingSystems' => TopOsResource::collection($topOperatingSystems),
            'newPayerCount'       => $newPayer,
            'loyalPayerCount'     => $loyalPayer
        ];
    }
}
