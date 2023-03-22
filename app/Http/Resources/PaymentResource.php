<?php

namespace App\Http\Resources;

use App\Models\Payment;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $income = null;
        $expense = null;
        $billType = $this->bill->type ?? null;

        if ($this->type == 'مصروفات') {
            $expense = $this->value;
        }elseif ($this->type == 'اقساط' && $billType == 'purchase'){
            $expense = $this->value;
        }elseif ($this->type == 'اقساط' && $billType == 'sale'){
            $income = $this->value;
        }elseif ($this->type == 'مدفوعات' && $this->client_id){
            $income = $this->value;
        }elseif ($this->type == 'مدفوعات' && $this->vendor_id){
            $expense = $this->value;
        }elseif ($this->type == 'تحويلات' && $this->bank_id == $request->bank->id){
            $expense = $this->value;
        }elseif ($this->type == 'تحويلات' && $this->received_bank_id == $request->bank->id){
            $income = $this->value;
        }

        $clientInstallment = Payment::whereHas('bill' , function ($q){
            $q->where('type' , 'sale');
        })->bankPayment('اقساط', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        $clientPayment = Payment::whereNotNull('client_id')->bankPayment('مدفوعات', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        $vendorInstallment = Payment::whereHas('bill' , function ($q){
            $q->where('type' , 'purchase');
        })->bankPayment('اقساط', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        $vendorPayment = Payment::whereNotNull('vendor_id')->bankPayment('مدفوعات', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        $expensePayment = Payment::bankPayment('مصروفات', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        $transaction_to = Payment::bankTransactionTo('تحويلات', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        $transaction_from = Payment::bankTransactionFrom('تحويلات', $request->bank->id , $this->transaction_date->format('Y-m-d H:i:s'));

        return [
            'id' => $this->id,
            'type' => $this->type,
            'transaction_description' => $this->transaction_description,
            'transaction_date' => $this->transaction_date->format('Y-m-d H:i'),
            'income' =>number_format( $income, 2),
            'expense' =>number_format( $expense, 2),
            'total' => number_format(($clientInstallment + $clientPayment + $transaction_to) - ($vendorInstallment + $vendorPayment + $expensePayment + $transaction_from), 2),
//            'total' => $transaction_from,
        ];
    }
}
