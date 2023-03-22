<?php

namespace App\Http\Resources\Api;

use App\Models\Bill;
use App\Models\Stock;
use Illuminate\Http\Resources\Json\JsonResource;

class BillPurchaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $main_price = ($this->pivot->count * $this->pivot->price);

        $bill = Bill::find($request->bill_id);
        ////////////////////////////////////////////////////////////////
        $bill->items()->updateExistingPivot($this->id, [
            'total_price' => $main_price ?? 0,
        ]);

        return [
            'id' => $this->id,
            'name' => $this->item->name ?? null,
            'lot_number' => $this->lot_number,
            'count' => $this->pivot->count ?? 1,
            'stock' => new GeneralResource(Stock::find($this->pivot->stock_id)) ?? null,
            'price' => $this->pivot->price ?? 0,
            'total_price' => $main_price ?? 0,
            'status' => (boolean)$this->pivot->status,
        ];
    }
}
