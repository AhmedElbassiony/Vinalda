<?php

namespace App\Http\Controllers;

use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernoratesController extends Controller
{
    public function index()
    {
        return view('governorate.index');
    }

    public function data()
    {
        return datatables(Governorate::all())
            ->addColumn('actions', 'governorate.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('governorate.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:governorates,name',
        ]);

        Governorate::create($data);

        session()->flash('success', 'تم إضافة المحافظة بنجاح');
        return redirect()->route('governorate.index');
    }

    public function edit(Governorate $governorate)
    {
        return view('governorate.edit' , compact('governorate'));
    }

    public function update(Request $request, Governorate $governorate)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:governorates,name,' . $governorate->id,
        ]);

        $governorate->update($data);

        session()->flash('success', 'تم تعديل المحافظة بنجاح');
        return redirect()->route('governorate.index');
    }

    public function destroy(Governorate $governorate)
    {
        $governorate->delete();
        session()->flash('success', 'تم حذف المحافظة بنجاح');
        return redirect()->route('governorate.index');
    }
}
