<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillItem extends Model
{
    protected $table = 'bill_item';

    use HasFactory;

    public function bill()
    {
        return $this->belongsTo(Bill::class , 'bill_id' , 'id');
    }

    public function item()
    {
        return $this->belongsTo(ItemChild::class , 'item_id' , 'id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class , 'stock_id' , 'id');
    }
}
