<?php

namespace App\Http\Resources;

use App\Models\BillItem;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemChildResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // dd($request->date_from);
        $countSale = 0;
        $countPurchase = 0;
        $countFrom = 0;
        $countTo = 0;

        if ($request->stock_id != null) {
            $countSale = BillItem::where('item_id', $this->id)
                ->where('stock_id', $request->stock_id)
                ->whereHas('bill', function ($q) {
                    $q->where('bills.type', 'sale');
                })->sum('count');

            $countPurchase = BillItem::where('item_id', $this->id)
                ->where('stock_id', $request->stock_id)
                ->whereHas('bill', function ($q) {
                    $q->where('bills.type', 'purchase');
                })->sum('count');

            $countFrom = BillItem::where('item_id', $this->id)
                ->whereHas('bill', function ($q) use ($request) {
                    $q->where('bills.type', 'exchange')
                        ->where('bills.stock_id', $request->stock_id);
                })->sum('count');

            $countTo = BillItem::where('item_id', $this->id)
                ->whereHas('bill', function ($q) use ($request) {
                    $q->where('bills.type', 'exchange')
                        ->where('bills.to_stock_id', $request->stock_id);
                })->sum('count');
        }
//        } else {
//            $countSale = BillItem::where('item_id', $this->id)
//                ->whereHas('bill', function ($q) {
//                    $q->where('bills.type', 'sale');
//                })->sum('count');
//
//            $countPurchase = BillItem::where('item_id', $this->id)
//                ->whereHas('bill', function ($q) {
//                    $q->where('bills.type', 'purchase');
//                })->sum('count');

//            $countFrom = BillItem::where('item_id', $this->id)
//                ->whereHas('bill', function ($q) use ($request) {
//                    $q->where('bills.type', 'exchange');
//                })->sum('count');
//
//            $countTo = BillItem::where('item_id', $this->item_id)
//                ->whereHas('bill', function ($q) use ($request) {
//                    $q->where('bills.type', 'exchange');
//                })->sum('count');
//        }
// $date_from = $request->input('date_from');
// $date_to = $request->input('date_to');
// dd($request->date_from);
// if ($request->date_from && $request->date_to) {
//     $countSale = BillItem::
//         whereHas('bill', function ($q) use ($request) {
//             $q->where('bills.type', 'sale')
//             ->where('bills.date' ,'=', $request->date_from);
//         })->groupBy('item_id')
//         ->sum('count');
//}

        return [
            'id' => $this->id,
            'code' => $this->code,
            'item' => $this->item->name ?? null,
            'lot_number' => $this->lot_number,
            'expire_date' => $this->expire_date->format('Y-m-d'),
            'count' => $countPurchase + $countTo - $countSale - $countFrom,
            'count_sale' => $countSale,
            'count_purchase' => $countPurchase,
            'count_from' => $countFrom,
            'count_to' => $countTo,
            'stock_id' => $request->stock_id ,
        ];
    }
}
