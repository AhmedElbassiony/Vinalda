<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return view('category.index');
    }

    public function data()
    {
        return datatables(Category::all())
            ->addColumn('actions', 'category.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:categories,name',
        ]);

        Category::create($data);

        session()->flash('success', 'تم إضافة الفئة بنجاح');
        return redirect()->route('category.index');
    }

    public function edit(Category $category)
    {
        return view('category.edit' , compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:categories,name,' . $category->id,
        ]);

        $category->update($data);

        session()->flash('success', 'تم تعديل الفئة بنجاح');
        return redirect()->route('category.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success', 'تم حذف الفئة بنجاح');
        return redirect()->route('category.index');
    }
}
