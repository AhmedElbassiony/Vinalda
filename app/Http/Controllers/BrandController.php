<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        return view('brand.index');
    }

    public function data()
    {
        return datatables(Brand::all())
            ->addColumn('actions', 'brand.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('brand.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:brands,name',
        ]);

        Brand::create($data);

        session()->flash('success', 'تم إضافة علامة تجارية بنجاح');
        return redirect()->route('brand.index');
    }

    public function edit(Brand $brand)
    {
        return view('brand.edit' , compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:brands,name,' . $brand->id,
        ]);

        $brand->update($data);

        session()->flash('success', 'تم تعديل العلامة تجارية بنجاح');
        return redirect()->route('brand.index');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        session()->flash('success', 'تم حذف العلامة تجارية بنجاح');
        return redirect()->route('brand.index');
    }
}
