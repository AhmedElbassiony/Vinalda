<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillSaleResource;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Method;
use App\Models\Payment;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillSaleController extends Controller
{
    public function index()
    {
        return view('bill_sale.index');
    }

    public function data()
    {
        return datatables(BillSaleResource::collection(Bill::where('type', 'sale')->latest()->get()))
            ->addColumn('actions', 'bill_sale.data_table.actions')
            ->addColumn('link', 'bill_sale.data_table.link')
            ->rawColumns(['actions','link'])
            ->toJson();
    }

    public function create()
    {
        $clients = Client::all();
        $stocks = Stock::all();
        $methods = Method::all();
        return view('bill_sale.create', compact('clients' , 'stocks' , 'methods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'stock_id' => 'required|exists:stocks,id',
            'method_id' => 'required|exists:methods,id',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);
        $data['type'] = 'sale';

        $bill = Bill::create($data);

        session()->flash('success', 'تم إضافة فاتورة مبيعات بنجاح');
        return redirect()->route('billSale.edit' , $bill->id);
    }

    public function edit(Bill $billSale)
    {
        $clients = Client::all();
        $methods = Method::all();
        return view('bill_sale.edit', compact('billSale' , 'clients' , 'methods'));
    }

    public function update(Request $request, Bill $billSale)
    {



        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
//            'stock_id' => 'required|exists:stocks,id',
            'method_id' => 'required|exists:methods,id',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);
        $billSale->update($data);

        session()->flash('success', 'تم تعديل فاتورة مبيعات بنجاح');
        return redirect()->route('billSale.edit' , $billSale->id);
    }

    public function destroy(Bill $itemChild)
    {
        $itemChild->delete();
        session()->flash('success', 'تم حذف الصنف بنجاح');
        return redirect()->route('itemChildren.index');
    }

    public function print(Bill $billSale)
    {
//        $numberToWords = new NumberToWords();
//        $digit  = $numberToWords->getCurrencyTransformer('ar');
        $main_total = DB::table('bill_item')
            ->where('bill_id' , '=' , $billSale->id)
            ->sum(DB::raw('count * price'));
        $discount = DB::table('bill_item')
            ->where('bill_id' , '=' , $billSale->id)
            ->sum(DB::raw('(discount/100) * (count * price)'));
        $tax = DB::table('bill_item')
            ->where('bill_id' , '=' , $billSale->id)
            ->sum(DB::raw('(tax/100) * (count * price)'));

        //  $total = DB::table('bill_item')
        //  ->where('bill_id' , '=' , $billSale->id)
        //  ->sum('total_price');

        // $total = $billSale->items()->sum('total_price');
        $total = $main_total -  $discount + $tax ?? 0;
        $paid = Payment::where('bill_id' , $billSale->id)->where('status' , 1)->sum('value');
        return view('bill_sale.print' ,  compact('billSale' , 'total' , 'paid' , 'main_total' , 'discount' , 'tax'));
    }
}
