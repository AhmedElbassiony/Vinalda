<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionPaymentResource;
use App\Models\Bank;
use App\Models\Payment;
use Illuminate\Http\Request;

class TransactionPaymentController extends Controller
{
    public function index()
    {
        return view('transaction_payment.index');
    }

    public function data()
    {
        return datatables(TransactionPaymentResource::collection(Payment::where('type', 'تحويلات')->latest()->get()))
            ->addColumn('actions', 'transaction_payment.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        $banks = Bank::all();
        return view('transaction_payment.create', compact('banks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bank_id' => 'required|exists:banks,id',
//            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
//            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $payment = Payment::create([
            'bank_id' => $data['bank_id'],
            'date' => now(),
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => now(),
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
            'type' => 'تحويلات',
        ]);

        if ($payment->status) {
            $payment->update([
                'transaction_date' => now(),
                'transaction_description' => __('dashboard.from_bank') . ($payment->bank->name ?? null) . ' ' . __('dashboard.to_bank') . ($payment->receivedBank->name ?? null),
            ]);
        }else{
            $payment->update([
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم إضافة عملية جديدة بنجاح');
        return redirect()->route('transaction-payment.index');
    }

    public function edit(Payment $transaction_payment)
    {
        $payment = $transaction_payment;
        $banks = Bank::all();
        $received_banks = Bank::whereNotIn('id' , [$transaction_payment->bank_id])->get();
        return view('transaction_payment.edit', compact('payment', 'banks' , 'received_banks'));
    }

    public function update(Request $request, Payment $transaction_payment)
    {
        $data = $request->validate([
            'bank_id' => 'required|exists:banks,id',
//            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
//            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $transaction_payment->update([
            'bank_id' => $data['bank_id'],
            'date' => now(),
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => now(),
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
        ]);

        if ($transaction_payment->status) {
            if ($transaction_payment->transaction_date){
                $transaction_payment->update([
                    'transaction_description' => __('dashboard.from_bank') . ($transaction_payment->bank->name ?? null) . ' ' . __('dashboard.to_bank') . ($transaction_payment->receivedBank->name ?? null),
                ]);
            }else{
                $transaction_payment->update([
                    'transaction_date' => now(),
                    'transaction_description' => __('dashboard.from_bank') . ($transaction_payment->bank->name ?? null) . ' ' . __('dashboard.to_bank') . ($transaction_payment->receivedBank->name ?? null),
                ]);
            }

        } else {
            $transaction_payment->update([
                'transaction_date' => null,
                'transaction_description' => null,
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم تعديل العملية بنجاح');
        return redirect()->route('transaction-payment.index');
    }

    public function destroy(Payment $transaction_payment)
    {
        $transaction_payment->delete();
        session()->flash('success', 'تم حذف العملية بنجاح');
        return redirect()->route('transaction-payment.index');
    }
}
