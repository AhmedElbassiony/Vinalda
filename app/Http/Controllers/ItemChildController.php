<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Item;
use App\Models\Stock;
use App\Models\BillItem;
use App\Models\ItemChild;
use Illuminate\Http\Request;
use App\Http\Resources\BillSaleResource;
use App\Http\Resources\ItemChildResource;
use App\Http\Resources\ItemDetailsResource;

class ItemChildController extends Controller
{
    public function index(Request $request)
    {
        $stock_id = $request->stock_id ?? 1;
        $stocks = Stock::all();
        return view('item_child.index' , compact('stock_id' , 'stocks'));
    }

    public function data()
    {
        return datatables(ItemChildResource::collection(ItemChild::all()))
            ->addColumn('actions', 'item_child.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function detailsData(Request $request, ItemChild $itemChildren)
    {

        $stock_idb=$request->stock_id ?? 1;

       $first= BillItem::where('item_id', $itemChildren->id)
        ->whereHas('bill', function ($q) use($stock_idb) {
             $q ->where('bills.type', 'exchange')
                ->where('bills.to_stock_id', $stock_idb );
        })      ->orderBy('bill_id' , 'desc')
                ->get();

        $second= BillItem::where('item_id', $itemChildren->id)
        -> where('stock_id', $stock_idb)
        ->orWhereNull('stock_id')
        ->whereHas('bill', function ($q) use($stock_idb) {
             $q->whereIn('bills.type', ['sale','purchase']) 
               ->where('bills.stock_id', $stock_idb );
        })     ->orderBy('bill_id' , 'desc')
               ->get();

        return datatables(ItemDetailsResource::collection($first->merge($second)->sortByDesc('bill_id')))
        ->addColumn('editBill', 'item_child.data_table.editBill')
        ->rawColumns(['editBill'])
        ->toJson();

    }


    public function create()
    {
        $items = Item::all();
        return view('item_child.create' , compact('items'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'expire_date' => 'required|date',
            'lot_number' => 'nullable|max:150',
        ]);

        ItemChild::create($data);

        session()->flash('success', 'تم إضافة صنف بنجاح');
        return redirect()->route('itemChildren.index');
    }

    public function edit(ItemChild $itemChild)
    {
        $items = Item::all();
        return view('item_child.edit' , compact('itemChild' , 'items'));    }

        public function details(ItemChild $itemChildren , Request $request)
        {
         
            $stock_id = $request->stock_id ?? 1;
         
            $countSale = 0;
            $countPurchase = 0;
            $countFrom = 0;
            $countTo = 0;
            $countSale = BillItem::where('item_id', $request->itemChildren->id)
            ->where('stock_id', $request->stock_id)
            ->whereHas('bill', function ($q) {
                $q->where('bills.type', 'sale');
            })->sum('count');
    
        $countPurchase = BillItem::where('item_id', $request->itemChildren->id)
            ->where('stock_id', $request->stock_id)
            ->whereHas('bill', function ($q) {
                $q->where('bills.type', 'purchase');
            })->sum('count');
    
        $countFrom = BillItem::where('item_id', $request->itemChildren->id)
            ->whereHas('bill', function ($q) use ($request) {
                $q->where('bills.type', 'exchange')
                    ->where('bills.stock_id', $request->stock_id);
            })->sum('count');
    
        $countTo = BillItem::where('item_id', $request->itemChildren->id)
            ->whereHas('bill', function ($q) use ($request) {
                $q->where('bills.type', 'exchange')
                    ->where('bills.to_stock_id', $request->stock_id);
            })->sum('count');
            $count = $countPurchase + $countTo - $countSale - $countFrom ;
            return view('item_child.details' , compact('itemChildren','stock_id' ,'countPurchase' , 'countSale' , 'countTo' ,'countFrom' ,'count'));   
         
         }

    public function update(Request $request, ItemChild $itemChild)
    {
        $data = $request->validate([
            'item_id' => 'required|exists:items,id',
            'expire_date' => 'required|date',
            'lot_number' => 'nullable|max:150',
        ]);

        $itemChild->update($data);

        session()->flash('success', 'تم تعديل الصنف بنجاح');
        return redirect()->route('itemChildren.index');
    }

    public function destroy(ItemChild $itemChild)
    {
        $itemChild->delete();
        session()->flash('success', 'تم حذف الصنف بنجاح');
        return redirect()->route('itemChildren.index');
    }
}
