<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return view('vendor.index');
    }

    public function data()
    {
        return datatables(Vendor::all())
            ->addColumn('actions', 'vendor.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('vendor.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|unique:vendors,mobile|digits_between:9,11',
        ]);

        Vendor::create($data);

        session()->flash('success', 'تم إضافة مورد بنجاح');
        return redirect()->route('vendors.index');
    }

    public function edit(Vendor $vendor)
    {
        return view('vendor.edit' , compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
            'mobile' => 'required|digits_between:9,11|unique:vendors,mobile,' . $vendor->id,
        ]);

        $vendor->update($data);

        session()->flash('success', 'تم تعديل المورد بنجاح');
        return redirect()->route('vendors.index');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        session()->flash('success', 'تم حذف المورد بنجاح');
        return redirect()->route('vendors.index');
    }
}
