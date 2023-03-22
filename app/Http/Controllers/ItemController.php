<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItemResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        return view('item.index');
    }

    public function data()
    {
        return datatables(ItemResource::collection(Item::all()))
            ->addColumn('actions', 'item.data_table.actions')
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('item.create' , compact('categories' , 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:items,name',
            'purchase_price' => 'nullable|numeric|min:0|max:999999',
            'sale_price' => 'nullable|numeric|min:0|max:999999',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable',
        ]);

        Item::create($data);

        session()->flash('success', 'تم إضافة صنف رئيسى بنجاح');
        return redirect()->route('items.index');
    }

    public function edit(Item $item)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('item.edit' , compact('item' , 'categories' , 'brands'));    }

    public function update(Request $request, Item $item)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150|unique:items,name,' . $item->id,
            'purchase_price' => 'nullable|numeric|min:0|max:999999',
            'sale_price' => 'nullable|numeric|min:0|max:999999',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'description' => 'nullable',
        ]);

        $item->update($data);

        session()->flash('success', 'تم تعديل الصنف الرئيسى بنجاح');
        return redirect()->route('items.index');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        session()->flash('success', 'تم حذف الصنف الرئيسى بنجاح');
        return redirect()->route('items.index');
    }
}
