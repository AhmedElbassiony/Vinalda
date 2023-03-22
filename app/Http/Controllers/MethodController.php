<?php

namespace App\Http\Controllers;

use App\Models\Method;
use Illuminate\Http\Request;

class MethodController extends Controller
{
    public function index()
    {
        return view('method.index');
    }

    public function data()
    {
        return datatables(Method::all())
            ->addColumn('actions', 'method.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('method.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:methods,name',
        ]);

        Method::create($data);

        session()->flash('success', 'تم إضافة طريقة دفع بنجاح');
        return redirect()->route('method.index');
    }

    public function edit(Method $method)
    {
        return view('method.edit' , compact('method'));
    }

    public function update(Request $request, Method $method)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:methods,name,' . $method->id,
        ]);

        $method->update($data);

        session()->flash('success', 'تم تعديل طريقة دفع بنجاح');
        return redirect()->route('method.index');
    }

    public function destroy(Method $method)
    {
        $method->delete();
        session()->flash('success', 'تم حذف طريقة دفع بنجاح');
        return redirect()->route('method.index');
    }
}
