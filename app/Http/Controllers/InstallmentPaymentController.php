<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstallmentPaymentResource;
use App\Models\Bank;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class InstallmentPaymentController extends Controller
{
    public function index(Bill $bill)
    {
        return view('installment_payment.index' , compact('bill'));
    }

    public function data(Bill $bill)
    {
        return datatables(InstallmentPaymentResource::collection(Payment::where('type', 'اقساط')->where('bill_id' , $bill->id)->latest()->get()))
            ->addColumn('actions', 'installment_payment.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create(Bill $bill)
    {
        $banks = Bank::all();
        return view('installment_payment.create', compact('banks' , 'bill'));
    }

    public function store(Bill $bill , Request $request)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $payment = Payment::create([
            'bill_id' => $bill->id,
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
            'type' => 'اقساط',
        ]);

        if ($payment->status) {
            $payment->update([
                'transaction_date' => now(),
                'transaction_description' => __('dashboard.installment') . ($payment->bill->code ?? null) . ' ' . ($payment->description ?? null),
            ]);
        }

        session()->flash('success', 'تم إضافة قسط جديد بنجاح');
        return redirect()->route('installment-payment.index' , $bill->id);
    }

    public function edit(Bill $bill , Payment $installment_payment)
    {
        $payment = $installment_payment;
        $banks = Bank::all();
        return view('installment_payment.edit', compact('payment', 'banks' , 'bill'));
    }

    public function update(Request $request, Bill $bill , Payment $installment_payment)
    {
        $data = $request->validate([
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $installment_payment->update([
            'bill_id' => $bill->id,
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
        ]);

        if ($installment_payment->status) {
            if ($installment_payment->transaction_date){
                $installment_payment->update([
                    'transaction_description' => __('dashboard.installment') . ($installment_payment->bill->code ?? null) . ' ' . ($installment_payment->description ?? null),
                ]);
            }else{
                $installment_payment->update([
                    'transaction_date' => now(),
                    'transaction_description' => __('dashboard.installment') . ($installment_payment->bill->code ?? null) . ' ' . ($installment_payment->description ?? null),
                ]);
            }

        } else {
            $installment_payment->update([
                'transaction_date' => null,
                'transaction_description' => null,
            ]);
        }

        session()->flash('success', 'تم تعديل القسط بنجاح');
        return redirect()->route('installment-payment.index' , $bill->id);
    }

    public function destroy(Bill $bill , Payment $installment_payment)
    {
        $installment_payment->delete();
        session()->flash('success', 'تم حذف القسط بنجاح');
        return redirect()->route('installment-payment.index' , $bill->id);
    }
}
