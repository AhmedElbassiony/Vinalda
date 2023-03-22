<?php

namespace App\Http\Resources;

use App\Models\BillItem;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

      
        $countIimport=0;
        $countExport=0;
        $countSale = 0;
        $countPurchase = 0;
        $countFrom = 0;
        $countTo = 0;
        $count = 0;

        $countSale = BillItem::where('item_id', $request->itemChildren->id)
        ->where('stock_id', $request->stock_id)
        ->whereHas('bill', function ($q) {
            $q->where('bills.type', 'sale')
            ->where('bill_id' , '<=' ,$this->bill->id);
        })->sum('count');

    $countPurchase = BillItem::where('item_id', $request->itemChildren->id)
        ->where('stock_id', $request->stock_id)
        ->whereHas('bill', function ($q) {
            $q->where('bills.type', 'purchase')
            ->where('bill_id' , '<=' ,$this->bill->id);
        })->sum('count');

    $countFrom = BillItem::where('item_id', $request->itemChildren->id)
        ->whereHas('bill', function ($q) use ($request) {
            $q->where('bills.type', 'exchange')
                ->where('bills.stock_id', $request->stock_id)
                ->where('bill_id' , '<=' ,$this->bill->id);
        })->sum('count');

    $countTo = BillItem::where('item_id', $request->itemChildren->id)
        ->whereHas('bill', function ($q) use ($request) {
            $q->where('bills.type', 'exchange')
                ->where('bills.to_stock_id', $request->stock_id)
                ->where('bill_id' , '<=' ,$this->bill->id);
        })->sum('count');


    $count = $countPurchase + $countTo - $countSale - $countFrom ;

   
           
            if($this->bill->type =='purchase'){
           
                $countIimport=$this->count;
                $bill_type='مشتريات';
               
           
            }elseif($this->bill->type=='sale'){
           
            $countExport=$this->count;
            $bill_type='مبيعات';
          

            }elseif($this->bill->type=='exchange'){
               
                if( $this->bill->to_stock_id == $request->stock_id ){

                $countIimport=$this->count;
                if($request->stock_id==1){
                    $bill_type=' تحويل من مخزن دمياط ';
                }else{ $bill_type=' تحويل من مخزن المنصورة ';}
              

                }else{
                    if($request->stock_id==1){
                        $bill_type=' تحويل الي مخزن دمياط ';
                    }else{ $bill_type=' تحويل الي مخزن المنصوره ';}
                $countExport=$this->count;
               
                }
              
        }
        return [
            'id' => $this->id,
            'code' => $this->bill->code,
           'bill_type'=>$bill_type,
           'bill_date'=>$this->bill->date->format('Y-m-d'),
           'info_name'=>$this->bill->client->name ?? null,
           'count_import'=>$countIimport,
           'count_export'=>$countExport,
           'count_after'=> $count ,
           'bill_id'=>$this->bill->id,
          
        ];
    }
}
