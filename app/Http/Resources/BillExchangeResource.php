<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillExchangeResource extends JsonResource
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
            'from_stock' => $this->stock->name ?? null,
            'to_stock' => $this->toStock->name ?? null,
            'date' => $this->date->format('Y-m-d'),
            'description' => $this->description?? 'لايوجد',
        ];
    }
}
