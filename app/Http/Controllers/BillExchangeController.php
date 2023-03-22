<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillExchangeResource;
use App\Http\Resources\BillSaleResource;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Method;
use App\Models\Payment;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillExchangeController extends Controller
{
    public function index()
    {
        return view('bill_exchange.index');
    }

    public function data()
    {
        return datatables(BillExchangeResource::collection(Bill::where('type', 'exchange')->latest()->get()))
            ->addColumn('actions', 'bill_exchange.data_table.actions')
            ->addColumn('link', 'bill_exchange.data_table.link')
            ->rawColumns(['actions','link'])
            ->toJson();
    }

    public function create()
    {
        $stocks = Stock::all();
        return view('bill_exchange.create', compact('stocks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'to_stock_id' => 'required|exists:stocks,id',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);

        $data['type'] = 'exchange';

        $bill = Bill::create($data);

        session()->flash('success', 'تم إضافة فاتورة التحويلات بنجاح');
        return redirect()->route('billExchange.edit' , $bill->id);
    }

    public function edit(Bill $billExchange)
    {
        $stocks = Stock::all();
        return view('bill_exchange.edit', compact('billExchange' , 'stocks'));
    }

    public function update(Request $request, Bill $billExchange)
    {
        $data = $request->validate([
            'stock_id' => 'required|exists:stocks,id',
            'to_stock_id' => 'required|exists:stocks,id',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);

//return $billExchange;
        $billExchange->update($data);
        session()->flash('success', 'تم تعديل فاتورة التحويلات بنجاح');
        return redirect()->route('billExchange.edit' , $billExchange->id);
    }

    public function print(Bill $billExchange)
    {
        return view('bill_exchange.print' ,  compact('billExchange'));
    }
}
