<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Governorate;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return view('client.index' , compact('clients'));
    }

    public function data()
    {
        return datatables(ClientResource::collection(Client::all()))
            ->addColumn('actions', 'client.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        $governorates = Governorate::all();
        return view('client.create' , compact('governorates'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|unique:clients,mobile|digits_between:9,11',
            'governorate_id' => 'required|exists:governorates,id',
            'address' => 'nullable',
        ]);

        Client::create($data);

        session()->flash('success', 'تم إضافة عميل بنجاح');
        return redirect()->route('clients.index');
    }

    public function edit(Client $client)
    {
        $governorates = Governorate::all();
        return view('client.edit', compact('client' , 'governorates'));
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|digits_between:9,11|unique:clients,mobile,' . $client->id,
            'governorate_id' => 'required|exists:governorates,id',
            'address' => 'nullable',
        ]);

        $client->update($data);

        session()->flash('success', 'تم تعديل العميل بنجاح');
        return redirect()->route('clients.index');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success', 'تم حذف العميل بنجاح');
        return redirect()->route('clients.index');
    }
}
