<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InstallmentPaymentResource extends JsonResource
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
            'id' => $this->id,
            'bill' => $this->bill_id,
            'date' => $this->date->format('Y-m-d') ?? null,
            'value' => $this->value,
            'status' => $this->status,
            'received_date' => $this->received_date->format('Y-m-d') ?? null,
            'received_bank_id' => $this->receivedBank->name ?? null,
            'description' => $this->description,
        ];
    }
}
