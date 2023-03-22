<?php

if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 2)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return response()->json(['data' => $randomString . rand(1000, 9999)]);
    }
}
//        $bills = Bill::where('client_id' , 7)->where('type' , 'sale')->pluck('id');
//        return Payment::whereIn('bill_id' , $bills)->where('type' , 'اقساط')->get();
//       return Bill::all();

//        return BillItem::where('status' , 1)->where('stock_id' , 1)
//            ->whereHas('bill', function ($q) {
//                $q->where('bills.type', 'purchase')->where('bills.status', 1);
//            })->groupBy('stock_id', 'item_id')
//            ->selectRaw('item_id , stock_id ,  sum(count) as count')
//            ->get();

//        return BillItem::where('item_id', 1)
////            ->where('stock_id', $this->stock_id)
//            ->whereHas('bill', function ($q) {
//                $q->where('bills.type', 'sale');
//            })->sum('count');

//        return ItemChild::find(1)->stocks()->get();

//        return ClientPaymentResource::collection(Payment::all()) ;
//        $items = ItemChild::whereHas('bills' , function ($q){
//            $q->where('bills.type' , 'purchase')->where('bills.status' , 1)->where('bill_item.status' , 1)->groupBy('bill_item.stock_id');
//        })->get();
//        $items = BillItem::where('status' , 1)->where('stock_id' , 1)
//            ->whereHas('bill', function ($q) {
//                $q->where('bills.type', 'purchase')->where('bills.status', 1);
//            })->groupBy('item_id')
////            })->groupBy('stock_id', 'item_id')
//            ->selectRaw('item_id , sum(count) as count')
//            ->get();
//
//        return $items;

//        return BillItem::groupBy('stock_id')
//            ->selectRaw('sum(no_of_pages) as sum, users_editor_id')
//            ->pluck('sum','users_editor_id');

//       $item = BillItem::
//           where('item_id' , 1)
//           ->where('stock_id' , 1)
//            ->whereHas('bill', function ($q) {
//                $q->where('bills.type', 'sale');
////            })->groupBy('item_id')
//            })->groupBy('stock_id')
//            ->selectRaw('sum(count) as count')
//            ->first()->count ?? 0;
//       return $item;
