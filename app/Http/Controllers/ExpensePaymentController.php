<?php

namespace App\Http\Controllers;

use App\Http\Resources\ExpensePaymentResource;
use App\Models\Bank;
use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Http\Request;

class ExpensePaymentController extends Controller
{
    public function index()
    {
        return view('expense_payment.index');
    }

    public function data()
    {
        return datatables(ExpensePaymentResource::collection(Payment::where('type', 'مصروفات')->latest()->get()))
            ->addColumn('actions', 'expense_payment.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        $expenses = Expense::all();
        $banks = Bank::all();
        return view('expense_payment.create', compact('expenses', 'banks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'expense_id' => 'required|exists:expenses,id',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $payment = Payment::create([
            'expense_id' => $data['expense_id'],
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
            'type' => 'مصروفات',
        ]);

        if ($payment->status) {
            $payment->update([
                'transaction_date' => now(),
                'transaction_description' => __('dashboard.expense') . ($payment->expense->name ?? null) . ' ' . ($payment->description ?? null),
            ]);
        }else{
            $payment->update([
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم إضافة مصروفات جديدة بنجاح');
        return redirect()->route('expense-payment.index');
    }

    public function edit(Payment $expense_payment)
    {
        $payment = $expense_payment;
        $expenses = Expense::all();
        $banks = Bank::all();
        return view('expense_payment.edit', compact('payment', 'expenses', 'banks'));
    }

    public function update(Request $request, Payment $expense_payment)
    {
        $data = $request->validate([
            'expense_id' => 'required|exists:expenses,id',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $expense_payment->update([
            'expense_id' => $data['expense_id'],
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
        ]);

        if ($expense_payment->status) {
            if ($expense_payment->transaction_date){
                $expense_payment->update([
                    'transaction_description' => __('dashboard.expense') . ($expense_payment->expense->name ?? null) . ' ' . ($expense_payment->description ?? null),
                ]);
            }else{
                $expense_payment->update([
                    'transaction_date' => now(),
                    'transaction_description' => __('dashboard.expense') . ($expense_payment->expense->name ?? null) . ' ' . ($expense_payment->description ?? null),
                ]);
            }

        } else {
            $expense_payment->update([
                'transaction_date' => null,
                'transaction_description' => null,
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم تعديل المصروفات بنجاح');
        return redirect()->route('expense-payment.index');
    }

    public function destroy(Payment $expense_payment)
    {
        $expense_payment->delete();
        session()->flash('success', 'تم حذف المصروفات بنجاح');
        return redirect()->route('expense-payment.index');
    }
}
