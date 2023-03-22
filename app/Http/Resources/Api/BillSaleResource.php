<?php

namespace App\Http\Resources\Api;

use App\Models\Bill;
use App\Models\Stock;
use Illuminate\Http\Resources\Json\JsonResource;

class BillSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $main_price = ($this->pivot->count * $this->pivot->price);
        if ($this->pivot->discount_type == 'نسبة %'){
            $discount = ($this->pivot->discount/100) * $main_price;
        }else{
            $discount = $this->pivot->discount;
        }

        if ($this->pivot->tax_type == 'نسبة %'){
            $tax = ($this->pivot->tax/100) * $main_price;
        }else{
            $tax = $this->pivot->tax;
        }

        $bill = Bill::find($request->bill_id);
        ////////////////////////////////////////////////////////////////
        $bill->items()->updateExistingPivot($this->id, [
            'total_price' => $main_price - $discount + $tax ?? 0,
        ]);
        return [
            'id' => $this->id,
            'name' => $this->item->name ?? null,
            'lot_number' => $this->lot_number,
            'count' => $this->pivot->count ?? 1,
            'stock' => Stock::find($this->pivot->stock_id)->name ?? null,
            'price' => $this->pivot->price ?? 0,
            'total_price' => $main_price - $discount + $tax ?? 0,
            'discount_type' => $this->pivot->discount_type ?? null,
            'discount' => $this->pivot->discount ?? 0,
            'tax_type' => $this->pivot->tax_type ?? null,
            'tax' => $this->pivot->tax ?? 0,
            'status' => (boolean)$this->pivot->status,
        ];
    }
}
