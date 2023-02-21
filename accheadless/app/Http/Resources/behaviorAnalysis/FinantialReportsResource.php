<?php

namespace App\Http\Resources\BehaviorAnalysis;

use App\Services\Helpers\DateTimeHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class FinantialReportsResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return 
        [
            'id' => "",
            'year' => (new DateTimeHelper())->getJalaliYear(),
            'month' => (new DateTimeHelper())->getJalaliMonth(),
            'deposit' => $this->where('transaction_type', 'deposit')->sum('amount'),
            'debit' => $this->where('transaction_type', 'withdraw')->sum('amount'),
            'wage' => $this->where('transaction_type', 'deposit')->sum('wage')
        ];
    }
}
