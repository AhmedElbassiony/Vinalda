<?php

namespace App\Http\Controllers;

use App\Http\Resources\VendorPaymentResource;
use App\Models\Bank;
use App\Models\Payment;
use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorPaymentController extends Controller
{
    public function index(Request $request)
    {
        $vendor_id = $request->vendor_id ?? null;
        $vendors = Vendor::all();
        return view('vendor_payment.index' , compact('vendors' , 'vendor_id'));
    }

    public function data(Request $request)
    {
        $q = Payment::query();

        $q->when($request->vendor_id, function ($query) use ($request) {
            $query->where('vendor_id', $request->vendor_id);
        });

        return datatables(VendorPaymentResource::collection($q->where('type' , 'مدفوعات')->whereNotNull('vendor_id')->latest()->get()))
            ->addColumn('actions', 'vendor_payment.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        $vendors = Vendor::all();
        $banks = Bank::all();
        return view('vendor_payment.create' , compact('vendors' , 'banks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $payment = Payment::create([
            'vendor_id' => $data['vendor_id'],
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
            'type' => 'مدفوعات',
        ]);

        if ($payment->status){
            $payment->update([
                'transaction_date' => now(),
                'transaction_description' => __('dashboard.paid_from_vendor') . ($payment->vendor->name ?? null),
            ]);
        }else{
            $payment->update([
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم إضافة مدفوع جديد بنجاح');
        return redirect()->route('vendor-payment.index');
    }

    public function edit(Payment $vendor_payment)
    {
        $payment = $vendor_payment;
        $vendors = Vendor::all();
        $banks = Bank::all();
        return view('vendor_payment.edit' , compact('payment' , 'vendors' , 'banks'));
    }

    public function update(Request $request, Payment $vendor_payment)
    {
        $data = $request->validate([
            'vendor_id' => 'required|exists:vendors,id',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $vendor_payment->update([
            'vendor_id' => $data['vendor_id'],
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
        ]);

        if ($vendor_payment->status) {
            if ($vendor_payment->transaction_date){
                $vendor_payment->update([
                    'transaction_description' => __('dashboard.paid_from_vendor') . ($vendor_payment->vendor->name ?? null),
                ]);
            }else{
                $vendor_payment->update([
                    'transaction_date' => now(),
                    'transaction_description' => __('dashboard.paid_from_vendor') . ($vendor_payment->vendor->name ?? null),
                ]);
            }

        } else {
            $vendor_payment->update([
                'transaction_date' => null,
                'transaction_description' => null,
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم تعديل المدفوع بنجاح');
        return redirect()->route('vendor-payment.index');
    }

    public function destroy(Payment $vendor_payment)
    {
        $vendor_payment->delete();
        session()->flash('success', 'تم حذف المدفوع بنجاح');
        return redirect()->route('vendor-payment.index');
    }
}
