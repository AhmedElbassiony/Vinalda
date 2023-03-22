<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        return view('expense.index');
    }

    public function data()
    {
        return datatables(Expense::all())
            ->addColumn('actions', 'expense.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('expense.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:expenses,name',
        ]);

        Expense::create($data);

        session()->flash('success', 'تم إضافة نوع مصروفات بنجاح');
        return redirect()->route('expense.index');
    }

    public function edit(Expense $expense)
    {
        return view('expense.edit' , compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:expenses,name,' . $expense->id,
        ]);

        $expense->update($data);

        session()->flash('success', 'تم تعديل نوع مصروفات بنجاح');
        return redirect()->route('expense.index');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        session()->flash('success', 'تم حذف نوع مصروفات بنجاح');
        return redirect()->route('expense.index');
    }
}
