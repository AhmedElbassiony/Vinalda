<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentResource;
use App\Models\Bank;
use App\Models\Payment;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function index()
    {
        return view('bank.index');
    }

    public function data()
    {
        return datatables(Bank::all())
            ->addColumn('actions', 'bank.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function show(Bank $bank)
    {
        return view('bank.show' , compact('bank'));
    }

    public function showData(Bank $bank)
    {
        return datatables(PaymentResource::collection(Payment::where(function ($query) use ($bank) {
            $query->where('received_bank_id', $bank->id)
                ->orWhere('bank_id', $bank->id);
        })->where('status' , 1)
            ->orderBy('transaction_date' , 'desc')
            ->get()))
            ->toJson();
    }

    public function create()
    {
        return view('bank.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:banks,name',
        ]);

        Bank::create($data);

        session()->flash('success', 'تم إضافة البنك بنجاح');
        return redirect()->route('bank.index');
    }

    public function edit(Bank $bank)
    {
        return view('bank.edit' , compact('bank'));
    }

    public function update(Request $request, Bank $bank)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:banks,name,' . $bank->id,
        ]);

        $bank->update($data);

        session()->flash('success', 'تم تعديل البنك بنجاح');
        return redirect()->route('bank.index');
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();
        session()->flash('success', 'تم حذف البنك بنجاح');
        return redirect()->route('bank.index');
    }
}
