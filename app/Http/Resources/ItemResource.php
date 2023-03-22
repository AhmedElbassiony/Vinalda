<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'name' => $this->name,
            'purchase_price' => $this->purchase_price,
            'sale_price' => $this->sale_price,
            'category' => $this->category->name ?? null,
            'brand' => $this->brand->name ?? null,
            'code' => $this->code,
            'description' => $this->description,
        ];
    }
}
