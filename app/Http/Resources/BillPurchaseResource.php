<?php

namespace App\Http\Resources;

use App\Models\Payment;
use Illuminate\Http\Resources\Json\JsonResource;

class BillPurchaseResource extends JsonResource
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
            'code' => $this->code,
            'vendor' => $this->vendor->name ?? null,
            'method' => $this->method->name ?? null,
            'date' => $this->date->format('Y-m-d'),
            'bill_status' => $this->status,
            'total' =>number_format( $this->items()->sum('total_price'), 2),
            'paid' =>number_format( Payment::where('bill_id' , $this->id)->where('status' , 1)->sum('value'), 2),
            'rest' => number_format(($this->items()->sum('total_price') ?? 0) - (Payment::where('bill_id' , $this->id)->where('status' , 1)->sum('value') ?? 0), 2),
            'description' => $this->description?? 'لايوجد',
        ];
    }
}
