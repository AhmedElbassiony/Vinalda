<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ItemChildResource;
use App\Http\Resources\ItemChildSaleResource;
use App\Http\Resources\ItemResource;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\ItemChild;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function itemPurchase()
    {
        return response()->json(ItemChildResource::collection(ItemChild::all()));
    }

    public function itemSale(Request $request, $billId)
    {
        $bill = Bill::findOrFail($billId);

        $request->bill = $bill;

        // $items = BillItem::where('status' , 1)->where('stock_id' , $bill->stock_id)
        //     ->whereHas('bill', function ($q) {
        //         $q->where('bills.type', 'purchase')->where('bills.status', 1);
        //     })->groupBy('stock_id', 'item_id')
        //     ->selectRaw('item_id , stock_id ,  sum(count) as count')
        //     ->get();
        return response()->json(ItemChildSaleResource::collection(ItemChild::all()));
    }

    public function itemExchange(Request $request, $billId)
    {
        $bill = Bill::findOrFail($billId);
        $request->bill = $bill;

        // $items = BillItem::where('status' , 1)->where('stock_id' , $bill->stock_id)
        //     ->whereHas('bill', function ($q) {
        //         $q->where('bills.type', 'purchase')->where('bills.status', 1);
        //     })->groupBy('stock_id', 'item_id')
        //     ->selectRaw('item_id , stock_id ,  sum(count) as count')
        //     ->get();
        // return response()->json(ItemChildSaleResource::collection($items));
        return response()->json(ItemChildSaleResource::collection(ItemChild::all()));
    }

    public function storePurchase(Request $request, $billId)
    {
        $bill = Bill::findOrFail($billId);
        $item = ItemChild::findOrFail($request->id);
        if ($bill->items->where('id', $request->id)->count() > 0) {
            return response()->json('error');
        } else {
            $bill->items()->attach($request->id, [
                'stock_id' => 1,
                'count' => 1,
                'price' => $item->item->purchase_price ?? 0,
            ]);
            return response()->json('success');
        }
    }

    public function storeSale(Request $request, $billId)
    {
        $bill = Bill::findOrFail($billId);
        $item = ItemChild::findOrFail($request->id);

        if ($bill->items->where('id', $request->id)->count() > 0) {
            return response()->json('error');
        }
        elseif ($item->bills()->where('type', 'purchase')->first()->pivot->status == 0){
            return response()->json('error');
        }
        else {
            $bill->items()->attach($request->id, [
                'stock_id' => $bill->stock_id,
                'count' => 1,
                'price' => $item->item->sale_price ?? 0,
            ]);
            return response()->json('success');
        }
    }

    public function storeExchange(Request $request, $billId)
    {
        $bill = Bill::findOrFail($billId);
        $item = ItemChild::findOrFail($request->id);

        if ($bill->items->where('id', $request->id)->count() > 0) {
            return response()->json('error');
        }
        elseif ($item->bills()->where('type', 'purchase')->first()->pivot->status == 0){
            return response()->json('error');
        }
        else {
            $bill->items()->attach($request->id, [
                'stock_id' => $bill->stock_id,
                'count' => 1,
                'price' => $item->item->sale_price ?? 0,
            ]);
            return response()->json('success');
        }
    }
}

