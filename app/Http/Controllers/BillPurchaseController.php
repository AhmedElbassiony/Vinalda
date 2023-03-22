<?php

namespace App\Http\Controllers;

use App\Http\Resources\BillPurchaseResource;
use App\Models\Bill;
use App\Models\Method;
use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BillPurchaseController extends Controller
{
    public function index()
    {
        return view('bill_purchase.index');
    }

    public function data()
    {
        return datatables(BillPurchaseResource::collection(Bill::where('type', 'purchase')->latest()->get()))
            ->addColumn('actions', 'bill_purchase.data_table.actions')
            ->addColumn('status', 'bill_purchase.data_table.status')
            ->addColumn('link', 'bill_purchase.data_table.link')
            ->rawColumns(['actions' , 'status','link'])
            ->toJson();
    }

    public function create()
    {
        $vendors = Vendor::all();
        $methods = Method::all();
        return view('bill_purchase.create', compact('vendors' , 'methods'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'method_id' => 'required|exists:methods,id',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);
        $data['type'] = 'purchase';

        $bill = Bill::create($data);

        session()->flash('success', 'تم إضافة فاتورة مشتريات بنجاح');
        return redirect()->route('billPurchase.edit' , $bill->id);
    }

    public function edit(Bill $billPurchase)
    {
        $vendors = Vendor::all();
        $methods = Method::all();
        return view('bill_purchase.edit', compact('billPurchase' , 'vendors' ,'methods'));
    }

    public function update(Request $request, Bill $billPurchase)
    {
        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'method_id' => 'required|exists:methods,id',
            'description' => 'nullable',
            'date' => 'required|date',
        ]);

        $billPurchase->update($data);

        session()->flash('success', 'تم تعديل فاتورة مشتريات بنجاح');
        return redirect()->route('billPurchase.edit' , $billPurchase->id);
    }

    public function destroy(Bill $itemChild)
    {
        $itemChild->delete();
        session()->flash('success', 'تم حذف الصنف بنجاح');
        return redirect()->route('itemChildren.index');
    }

    public function print(Bill $billPurchase)
    {
//        $numberToWords = new NumberToWords();
//        $digit  = $numberToWords->getCurrencyTransformer('ar');
        $total = $billPurchase->items()->sum('total_price');
        $paid = Payment::where('bill_id' , $billPurchase->id)->where('status' , 1)->sum('value');
        return view('bill_purchase.print' ,  compact('billPurchase' , 'total' , 'paid'));
    }
}
