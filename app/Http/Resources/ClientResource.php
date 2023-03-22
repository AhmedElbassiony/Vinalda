<?php

namespace App\Http\Resources;

use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */




    public function toArray($request)
    {

        $total = 0;
        $rest = 0;
        $total_rest = 0;
      

        $bills = Bill::where('client_id' , $this->id)->get();
        $client_payments_true =  $this->payments()->where('status', 1)->get();
        $client_payments_false = $this->payments()->where('status', 0)->get();
        $payments_true = Payment::whereIn('bill_id', $bills->pluck('id'))->where('type', 'اقساط')->where('status', 1)->get();
        $payments_false = Payment::whereIn('bill_id', $bills->pluck('id'))->where('type', 'اقساط')->where('status', 0)->get();

        foreach ($bills as $bill) {
            $total += round($bill->items()->sum('total_price'), 2);
            $rest += ($bill->items()->sum('total_price') ?? 0) - (\App\Models\Payment::where('bill_id', $bill->id)->where('type' , 'اقساط')->where('status', 1)->sum('value') ?? 0);
        }

        foreach (Bill::where('client_id' , $this->id)->get() as $bill) {
            $total_rest += ($bill->items()->sum('total_price') ?? 0) - (\App\Models\Payment::where('bill_id', $bill->id)->where('type' , 'اقساط')->where('status', 1)->sum('value') ?? 0);
        }

        $total_rest -= (\App\Models\Payment::where('client_id', $this->id)->where('type' , 'مدفوعات')->where('status', 1)->sum('value') ?? 0);

      




        return [
            'id' => $this->id,
            'name' => $this->name,
            'payments_true'=>  number_format($payments_true->sum('value'),2),
            'payments_false'=>  number_format($payments_false->sum('value'),2),
            'client_payments_true'=>  number_format($client_payments_true->sum('value'),2),
            'client_payments_false'=>  number_format($client_payments_false->sum('value'),2),
            'total_payments'=> number_format($total,2),
            'rest'=> number_format($total_rest,2),
            'mobile' => $this->mobile,
            'governorate' => $this->governorate->name ?? null,
            'address' => $this->address,
        ];
    }
}
