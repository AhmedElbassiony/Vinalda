<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BillPurchaseResource;
use App\Http\Resources\Api\BillSaleResource;
use App\Models\Bill;
use App\Models\ItemChild;
use App\Models\Stock;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Bill $bill)
    {
        $items = $bill->items;
        if ($bill->type == 'purchase') {
            return response()->json(BillPurchaseResource::collection($items));
        } else {
            return response()->json(BillSaleResource::collection($items));
        }
    }

    public function update(Request $request, Bill $bill)
    {
        $data = $request->models;
//        return $data;
        if ($bill->type == 'purchase') {
            foreach ($data as $item) {
                if ($item['status'] == "false") {
                    $item['status'] = 0;
                } else {
                    $item['status'] = 1;
                }
                if ($item['status'] == 0) {
                    $itemChild = ItemChild::findOrFail($item['id']);
//                    if ($itemChild->bills()->where('type', 'sale')->count() > 0) {
//                        return false;
//                    }
                }
                $bill->items()->updateExistingPivot($item['id'], [
                    'count' => $item['count'] ?? 1,
                    'stock_id' => Stock::where('name', $item['stock']['value'])->first()->id,
                    'price' => $item['price'],
//                    'total_price' => $item['count'] * $item['price'],
                    'status' => $item['status'],
                ]);
            }
        } elseif ($bill->type == 'exchange') {
            foreach ($data as $item) {
                if ($item['status'] == "false") {
                    $item['status'] = 0;
                } else {
                    $item['status'] = 1;
                }
                $bill->items()->updateExistingPivot($item['id'], [
                    'count' => $item['count'] ?? 1,
                    'status' => $item['status'],
                ]);
            }
        } else {
            foreach ($data as $item) {
                if ($item['status'] == "false") {
                    $item['status'] = 0;
                } else {
                    $item['status'] = 1;
                }
                $bill->items()->updateExistingPivot($item['id'], [
                    'count' => $item['count'] ?? 1,
                    'price' => $item['price'],
//                    'total_price' => $item['count'] * $item['price'],
                    'discount_type' => $item['discount_type'],
                    'discount' => $item['discount'],
                    'tax_type' => $item['tax_type'],
                    'tax' => $item['tax'],
                    'status' => $item['status'],
                ]);
            }
        }
        return $data;
    }

    public function destroy(Request $request, Bill $bill)
    {
        $data = $request->models;

        if ($bill->type == 'purchase') {
            foreach ($data as $item) {
                $bill->items()->detach($item['id']);
            }
        } else {
            foreach ($data as $item) {
                $bill->items()->detach($item['id']);
            }
        }
    }
}
