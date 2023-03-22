<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function destroy(Bill $bill)
    {
        if ($bill->items()->count() > 0){
            session()->flash('error', 'لا يمكنك حذف الفاتورة لاحتوائها على عناصر');
            return back();
        }elseif(Payment::where('bill_id' , $bill->id)->count() > 0){
            session()->flash('error', 'لا يمكنك حذف الفاتورة لاحتوائها على اقساط');
            return back();
        }else{
            $bill->delete();
            session()->flash('success', 'تم حذف الفاتورة بنجاح');
            return back();
        }
    }

    public function updateStatus(Request $request, Bill $bill)
    {
        ($request->status == "on") ? $bill->completed() : $bill->incomplete();

        session()->flash('success', 'تم تعديل الفاتورة بنجاح');

        if ($bill->type == 'purchase'){
            return redirect()->route('billPurchase.index');

        }else{
            return redirect()->route('billSale.index');
        }
    }
}
