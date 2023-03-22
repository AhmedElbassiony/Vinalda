<?php

namespace App\Http\Controllers;


use DatePeriod;
use DateInterval;
use App\Models\Client;
use App\Models\BillItem;
use Carbon\CarbonPeriod;
use App\Models\ItemChild;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ClientResource;
use App\Http\Resources\ItemChildResource;

class ReportController extends Controller
{
    public function client()
    {
        $clients = Client::all();
        return view('report.client', compact('clients'));
    }

    public function allClientsData()
    {
        return datatables(ClientResource::collection(Client::orderBy('name')->get()))
            ->toJson();
    }

    public function allClients()
    {
        $clients = Client::all();
        return view('report.allClients', compact('clients'));
    }

    public function allItems()
    {
        $items =  ItemChild::all();
        return view('report.allItems', compact('items'));
    }

    public function allItemsIndex(Request $request)

    {
        $date_from = $request->input('date_from');
        $date_to = $request->input('date_to');
        $months = [];
        $total = 0;
        $count = 0;
        $Purchases=0;
        $rest = 0;
        $payments =0;
        $items =  ItemChild::all();
        // dd($request->input('date_from'));


        foreach (CarbonPeriod::create($date_from, '1 month', $date_to) as $month) {
            $months[$month->format('Y-m')] = $month->format('Y-F');
        }
        $firstDate = date("Y-m-31", strtotime($date_to));
        $secondDate = date("Y-m-d", strtotime($date_from));
        // dd( $firstDate);


        $itemsSalessAll = DB::table('bill_item')
            ->join('bills', 'bill_item.bill_id', '=', 'bills.id')
            ->join('items', 'bill_item.item_id', '=', 'items.id')
            ->selectRaw("items.id id ,name name, SUM(count) payments")
            // ->where('bill_item.item_id', 2)
            ->where('bills.type', 'sale')
            ->groupBy('name', 'id')
            ->orderBy('items.id')
            ->get();
        $itemSales = $itemsSalessAll->map(function ($value) {
            return [
                'id' => $value->id,
            ];
        })->toArray();
       

        $itemsPurchasesAll = DB::table('bill_item')
            ->join('bills', 'bill_item.bill_id', '=', 'bills.id')
            ->join('items', 'bill_item.item_id', '=', 'items.id')
            ->selectRaw("items.id id ,name name, SUM(count) payments")
            // ->where('bill_item.item_id', 2)
            ->where('bills.type', 'purchase')
            ->groupBy('name', 'id')
            ->orderBy('items.id')
            ->get();
        $itemPurchases = $itemsPurchasesAll->map(function ($value) {
            return [
                'id' => $value->id,
            ];
        })->toArray();

        $itemsDeatailsPayments = DB::table('bill_item')
            ->join('bills', 'bill_item.bill_id', '=', 'bills.id')
            ->join('items', 'bill_item.item_id', '=', 'items.id')
            ->selectRaw("items.id id ,name name, SUM(count) payments, DATE_FORMAT(date, '%Y-%M') month")
            // ->where('bill_item.item_id', 2)
            ->where('bills.type', 'sale')
            ->whereBetween('date', [$secondDate, $firstDate])
            ->groupBy('name', 'id', 'month')
            ->orderBy('items.id')
            ->orderBy('month')
            ->get();
        $itemPayment = $itemsDeatailsPayments->map(function ($value) {
            return [
                'id' => $value->id,
                'month' => $value->month,
            ];
        })->toArray();

        $itemsDeatailsPurchase = DB::table('bill_item')
            ->join('bills', 'bill_item.bill_id', '=', 'bills.id')
            ->join('items', 'bill_item.item_id', '=', 'items.id')
            ->selectRaw("items.id id ,name name, SUM(count) purchases")
            ->where('bills.type', 'purchase')
            ->whereBetween('date', [$secondDate, $firstDate])
            ->groupBy('name', 'id')
            ->orderBy('items.id')
            ->get();

        $itemPurchase = $itemsDeatailsPurchase->map(function ($value) {
            return [
                'id' => $value->id,
            ];
        })->toArray();

        // dd($itemsDeatailsPurchase);
        // dd( $itemsDeatails);
        return view('report.allItemsIndex', compact(
            'items',
             'months',
              'itemsDeatailsPayments',
               'itemPayment', 
               'total', 
               'itemsDeatailsPurchase',
                'itemPurchase',
                 'rest',
                 'count',
                 'itemsSalessAll',
                 'itemsPurchasesAll' ,
                  'itemPurchases',
                  'itemSales',
                  'Purchases',
                  'payments'
                ));
    }

    // public function allItemsData(Request $request)
    // {
    //     // dd($request->date_from);
    //     return datatables(ItemChildResource::collection(ItemChild::all()))
    //         // ->addColumn('actions', 'item_child.data_table.actions')
    //         // ->rawColumns(['actions'])
    //         ->toJson();
    // }
}
