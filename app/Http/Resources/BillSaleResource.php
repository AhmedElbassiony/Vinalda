<?php

namespace App\Http\Resources;

use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\JsonResource;

class BillSaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $main_total = DB::table('bill_item')
        ->where('bill_id' , '=' , $this->id)
        ->sum(DB::raw('count * price'));
       $discount = DB::table('bill_item')
        ->where('bill_id' , '=' , $this->id)
        ->sum(DB::raw('(discount/100) * (count * price)'));
        $tax = DB::table('bill_item')
        ->where('bill_id' , '=' , $this->id)
        ->sum(DB::raw('(tax/100) * (count * price)'));

   
   
        return [
            'id' => $this->id,
            'code' => $this->code,
            'client' => $this->client->name ?? null,
            'date' => $this->date->format('Y-m-d'),
            'method' => $this->method->name ?? null,
            'stock' => $this->stock->name ?? null,
            'total' => number_format($main_total -  $discount + $tax ?? 0, 2),
            // 'total' => round($this->items()->sum('total_price'), 2),
            'paid' =>number_format( Payment::where('bill_id' , $this->id)->where('status' , 1)->sum('value'), 2),
            'rest' =>  number_format(($main_total -  $discount + $tax ?? 0) - (Payment::where('bill_id' , $this->id)->where('status' , 1)->sum('value') ?? 0), 2),
            'description' => $this->description??'لا يوجد ',
        ];
    }
}
