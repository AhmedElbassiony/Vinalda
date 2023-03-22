<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientPaymentResource;
use App\Models\Bank;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Client;
use App\Models\ItemChild;
use App\Models\Payment;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class DashboardController extends Controller
{
    public function data($id)
    {
        $banks = Bank::whereNotIn('id', [$id])->get();
        return response()->json($banks);
    }

    public function stock($id)
    {
        $stocks = Stock::whereNotIn('id', [$id])->get();
        return response()->json($stocks);
    }

    public function index()
    {
//        $bills = Client::find(7)->bills()->get();
//return $bills;
//        return Bill::query()->where('client_id' , 7)
//            ->where('date', '>=', date($date_from))
//            ->where('date', '<=', $date_to);
        return view('index');
    }

    public function generate_pdf(Request $request)
    {
//        dd($request->date_to);
        $client = Client::findOrFail($request->client_id);
        $total = 0;
        $rest = 0;
        $total_rest = 0;
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');

        $bills = Bill::where('client_id' , $client->id)->get();
        $client_payments_true = $client->payments()->where('status', 1)->get();
        $client_payments_false = $client->payments()->where('status', 0)->get();
        $payments_true = Payment::whereIn('bill_id', $bills->pluck('id'))->where('type', 'اقساط')->where('status', 1)->get();
        $payments_false = Payment::whereIn('bill_id', $bills->pluck('id'))->where('type', 'اقساط')->where('status', 0)->get();

        if ($date_from && $date_to) {
            $bills = $bills->where('date', '>=', date($date_from))
                ->where('date', '<=', $date_to);
            $client_payments_true = $client_payments_true->where('date', '>=', $date_from)
                ->where('date', '<=', $date_to);
            $client_payments_false = $client_payments_false->where('date', '>=', $date_from)
                ->where('date', '<=', $date_to);
            $payments_true = $payments_true->where('date', '>=', $date_from)
                ->where('date', '<=', $date_to);
            $payments_false = $payments_false->where('date', '>=', $date_from)
                ->where('date', '<=', $date_to);
        } elseif ($date_from) {
            $bills = $bills->where('date', '>=', $date_from);
            $client_payments_true = $client_payments_true->where('date', '>=', $date_from);
            $client_payments_false = $client_payments_false->where('date', '>=', $date_from);
            $payments_true = $payments_true->where('date', '>=', $date_from);
            $payments_false = $payments_false->where('date', '>=', $date_from);
        } elseif ($date_to) {
            $bills = $bills->where('date', '<=', $date_to);
            $client_payments_true = $client_payments_true->where('date', '<=', $date_to);
            $client_payments_false = $client_payments_false->where('date', '<=', $date_to);
            $payments_true = $payments_true->where('date', '<=', $date_to);
            $payments_false = $payments_false->where('date', '<=', $date_to);
        }

        foreach ($bills as $bill) {
            $total += round($bill->items()->sum('total_price'), 2);
            $rest += ($bill->items()->sum('total_price') ?? 0) - (\App\Models\Payment::where('bill_id', $bill->id)->where('type' , 'اقساط')->where('status', 1)->sum('value') ?? 0);
        }

        foreach (Bill::where('client_id' , $client->id)->get() as $bill) {
            $total_rest += ($bill->items()->sum('total_price') ?? 0) - (\App\Models\Payment::where('bill_id', $bill->id)->where('type' , 'اقساط')->where('status', 1)->sum('value') ?? 0);
        }

        $total_rest -= (\App\Models\Payment::where('client_id', $client->id)->where('type' , 'مدفوعات')->where('status', 1)->sum('value') ?? 0);

        $data = [
            'foo' => 'bar',
            'total_rest' => $total_rest,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'client' => $client,
            'bills' => $bills,
            'client_payments_true' => $client_payments_true,
            'client_payments_false' => $client_payments_false,
            'payments_true' => $payments_true,
            'payments_false' => $payments_false,
            'total' => $total,
            'rest' => $rest,
        ];
        $pdf = PDF::loadView('pdf', $data);
        return $pdf->stream('document.pdf');
    }
}
