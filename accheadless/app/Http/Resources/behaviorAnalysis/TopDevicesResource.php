<?php

namespace App\Http\Resources\BehaviorAnalysis;

use Illuminate\Http\Resources\Json\JsonResource;

class TopDevicesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => '',
            'label' => $this->device_name,
            'value' => $this->transaction_logs_count
        ];
    }
}
