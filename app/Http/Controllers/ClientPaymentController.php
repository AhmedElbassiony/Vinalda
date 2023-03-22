<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientPaymentResource;
use App\Models\Bank;
use App\Models\Client;
use App\Models\Payment;
use Illuminate\Http\Request;

class ClientPaymentController extends Controller
{
    public function index(Request $request)
    {
        $client_id = $request->client_id ?? null;
        $clients = Client::all();
        return view('client_payment.index' , compact('clients' , 'client_id'));
    }

    public function data(Request $request)
    {
        $q = Payment::query();

        $q->when($request->client_id, function ($query) use ($request) {
            $query->where('client_id', $request->client_id);
        });

        return datatables(ClientPaymentResource::collection($q->where('type', 'مدفوعات')->whereNotNull('client_id')->latest()->get()))
            ->addColumn('actions', 'client_payment.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        $clients = Client::all();
        $banks = Bank::all();
        return view('client_payment.create', compact('clients', 'banks'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $payment = Payment::create([
            'client_id' => $data['client_id'],
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
            'type' => 'مدفوعات',
        ]);

        if ($payment->status) {
            $payment->update([
                'transaction_date' => now(),
                'transaction_description' => __('dashboard.paid_from_client') . ($payment->client->name ?? null),
            ]);
        }else{
            $payment->update([
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم إضافة مدفوع جديد بنجاح');
        return redirect()->route('client-payment.index');
    }

    public function edit(Payment $client_payment)
    {
        $payment = $client_payment;
        $clients = Client::all();
        $banks = Bank::all();
        return view('client_payment.edit', compact('payment', 'clients', 'banks'));
    }

    public function update(Request $request, Payment $client_payment)
    {
        $data = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'value' => 'required|numeric|min:0|max:99999999',
            'status' => 'required|boolean',
            'received_date' => 'required|date',
            'received_bank_id' => 'required|exists:banks,id',
            'description' => 'nullable',
        ]);

        $client_payment->update([
            'client_id' => $data['client_id'],
            'date' => $data['date'],
            'value' => $data['value'],
            'status' => $data['status'],
            'received_date' => $data['received_date'],
            'received_bank_id' => $data['received_bank_id'],
            'description' => $data['description'],
        ]);

        if ($client_payment->status) {
            if ($client_payment->transaction_date){
                $client_payment->update([
                    'transaction_description' => __('dashboard.paid_from_client') . ($client_payment->client->name ?? null),
                ]);
            }else{
                $client_payment->update([
                    'transaction_date' => now(),
                    'transaction_description' => __('dashboard.paid_from_client') . ($client_payment->client->name ?? null),
                ]);
            }

        } else {
            $client_payment->update([
                'transaction_date' => null,
                'transaction_description' => null,
                'received_date' => null,
            ]);
        }

        session()->flash('success', 'تم تعديل المدفوع بنجاح');
        return redirect()->route('client-payment.index');
    }

    public function destroy(Payment $client_payment)
    {
        $client_payment->delete();
        session()->flash('success', 'تم حذف المدفوع بنجاح');
        return redirect()->route('client-payment.index');
    }
}
