<?php

namespace App\Http\Controllers\Analysis;

use App\Http\Controllers\Controller;
use App\Http\Resources\behaviorAnalysis\PaysResource;
use App\Http\Resources\BehaviorAnalysis\TopBrowsersResource;
use App\Http\Resources\BehaviorAnalysis\TopDevicesResource;
use App\Http\Resources\BehaviorAnalysis\TopOperatorsResource;
use App\Http\Resources\BehaviorAnalysis\TopOsResource;
use App\Http\Resources\BehaviorAnalysis\TopProviencesResource;
use App\Models\Browser;
use App\Models\Device;
use App\Models\OperatingSystem;
use App\Models\Operator;
use App\Models\Provience;
use App\Models\Transaction;
use App\Models\TransactionLog;
use App\Repository\Eloquent\TransactionRepositoy;
use App\Repository\TransactionRepositoryInterface;
use App\Traits\ScopeTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class DataAnalysisController extends Controller
{

    private $repo;
    public function __construct(TransactionRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    //use ScopeTrait;
    public function analysis (Request $request, Transaction $transaction)
    {
        // gateway_id and timeline should be on request payload
        $payload = $request->all();
        $timeline = [
            $transaction::LAST_SEVEN_DAYS  => 'lastSevenDays',
            $transaction::LAST_WEEK        => 'lastWeek',
            $transaction::LAST_THIRTY_DAYS => 'lastThirtyDays',
            $transaction::LAST_MONTH       => 'lastMonth',
            $transaction::LAST_THREE_MONTH => 'lastThreeMonth',
            $transaction::LAST_SIX_MONTH   => 'lastSixMonth',
            $transaction::LAST_YEAR        => 'lastYear',
        ];

        if (empty($payload)) { 

            // use repository for this part
            $besTr = $this->repo->findTopTransactios(['transactionLogs']);
            dd($besTr);

            $bestPays = Transaction::selectRaw('amount, count(*) as count')->transactionType('deposit')->groupBy('amount')->get();
            $topProviences = Provience::withCount('transactionLogs')->get();
            $topBrowsers = Browser::withCount('transactionLogs')->get();
            $topOperators = Operator::withCount('transactionLogs')->get();

            $newPayer = Transaction::transactionType('deposit')->cardNumber()->having('counts', '=', 1)->count();
            $loyalPayer = Transaction::transactionType('deposit')->cardNumber()->having('counts', '>=', 2)->count();
            return [
                'bestPays'             => PaysResource::collection($bestPays),
                'topProviences'        => TopProviencesResource::collection($topProviences),
                'bestOperator'         => TopOperatorsResource::collection($topOperators),
                'topBrowsers'          => TopBrowsersResource::collection($topBrowsers),
                // 'bestDevices'          => TopDevicesResource::collection($topDevices),
                // 'bestOperatingSystems' => TopOsResource::collection($topOperatingSystems),
                'newPayerCount'        => $newPayer,
                'loyalPayerCount'      => $loyalPayer
            ];
        }

        if (!is_null($payload) && $request->has('timeline')) {

            //dd($request->timeline);
            //dd($timeline[$request->timeline]);
            $bestPays = Transaction::selectRaw('amount, count(*) as count')->$timeline[$request->timeline]()->transactionType('deposit')->groupBy('amount')->get();
            dd($bestPays); 
        }

        // if (is_null($request->gateway_id)) {
        //     return [
        //         'bestPays' => '',  //a resource collectin
        //     ];
        // }
    }
}
