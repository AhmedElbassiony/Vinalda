<?php

namespace App\Http\Resources\Api;

use App\Models\BillItem;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemChildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public function toArray($request)
    // {
    //     return [
    //         'id' => $this->id,
    //         'code' => $this->code,
    //         'item' => $this->item->name ?? null,
    //         'lot_number' => $this->lot_number,
    //         'expire_date' => $this->expire_date->format('Y-m-d'),
    //     ];
    // }

      public function toArray($request)
    {
            $bill = $request->bill;
            $countSale = 0;
            $countPurchase = 0;
            $countFrom = 0;
            $countTo = 0;
    
                $countSale = BillItem::where('item_id', $this->id)
                    // ->where('stock_id', $bill->stock_id)
                    ->whereHas('bill', function ($q) {
                        $q->where('bills.type', 'sale');
                    })->sum('count');
    
                $countPurchase = BillItem::where('item_id', $this->id)
                    // ->where('stock_id', $bill->stock_id)
                    ->whereHas('bill', function ($q) {
                        $q->where('bills.type', 'purchase');
                    })->sum('count');
    
                $countFrom = BillItem::where('item_id', $this->id)
                    ->whereHas('bill', function ($q) use ($bill) {
                        $q->where('bills.type', 'exchange');
                            // ->where('bills.stock_id', $bill->stock_id);
                    })->sum('count');
    
                $countTo = BillItem::where('item_id', $this->id)
                    ->whereHas('bill', function ($q) use ($bill) {
                        $q->where('bills.type', 'exchange');
                            // ->where('bills.to_stock_id', $bill->stock_id);
                    })->sum('count');
    
            // return [
            //     'id' => $this->id,
            //     'code' => $this->code,
            //     'item' => $this->item->name ?? null,
            //     'lot_number' => $this->lot_number,
            //     'expire_date' => $this->expire_date->format('Y-m-d'),
            //     'count' => $countPurchase + $countTo - $countSale - $countFrom,
            //     'count_sale' => $countSale,
            //     'count_purchase' => $countPurchase,
            //     'count_from' => $countFrom,
            //     'count_to' => $countTo,
            // ];

        return [
            'id' => $this->id,
            'item' => $this->item->name ?? null,
            'code' => $this->code ?? null,
            'lot_number' => $this->lot_number ?? null,
            'count' => $countPurchase + $countTo - $countSale - $countFrom,
            // 'stock' => $bill->stock->name,
            'expire_date' => $this->expire_date->format('Y-m-d'),
        ];
    }
}
