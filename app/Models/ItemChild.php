<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemChild extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['code' , 'item_id' , 'expire_date' , 'lot_number'];

    protected $casts = [
      'expire_date' => 'date',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class , 'item_id' , 'id');
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class , 'bill_item' , 'item_id' , 'bill_id')
            ->withPivot('stock_id' , 'count' , 'price'  , 'status' , 'total_price' , 'discount_type' , 'discount' , 'tax_type' , 'tax');
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (ItemChild $item) {
            $item->code = "ITC" . str_pad($item->id, 4, 0, STR_PAD_LEFT);
            $item->save();
        });
    }
}
