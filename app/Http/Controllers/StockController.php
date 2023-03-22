<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index()
    {
        return view('stock.index');
    }

    public function data()
    {
        return datatables(Stock::all())
            ->addColumn('actions', 'stock.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('stock.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:stocks,name',
        ]);

        Stock::create($data);

        session()->flash('success', 'تم إضافة المخزن بنجاح');
        return redirect()->route('stock.index');
    }

    public function edit(Stock $stock)
    {
        return view('stock.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:stocks,name,' . $stock->id,
        ]);

        $stock->update($data);

        session()->flash('success', 'تم تعديل المخزن بنجاح');
        return redirect()->route('stock.index');
    }

    public function destroy(Stock $stock)
    {
        $stock->delete();
        session()->flash('success', 'تم حذف المخزن بنجاح');
        return redirect()->route('stock.index');
    }
}
