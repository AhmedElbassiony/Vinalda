<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{

    
    use HasFactory, SoftDeletes;

    protected $fillable = ['client_id', 'vendor_id', 'method_id', 'code', 'type', 'date' , 'status' , 'stock_id' , 'description' , 'to_stock_id'];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class , 'vendor_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class , 'client_id', 'id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class , 'stock_id', 'id');
    }

    public function toStock()
    {
        return $this->belongsTo(Stock::class , 'to_stock_id', 'id');
    }

    public function method()
    {
        return $this->belongsTo(Method::class , 'method_id', 'id');
    }

    public function items()
    {
        return $this->belongsToMany(ItemChild::class , 'bill_item' , 'bill_id' , 'item_id')
            ->withPivot('stock_id' , 'count' , 'price'  , 'status' , 'total_price' , 'discount_type' , 'discount' , 'tax_type' , 'tax');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class , 'bill_id', 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (Bill $bill) {
            $bill->code = "B" . str_pad($bill->id, 4, 0, STR_PAD_LEFT);
            $bill->save();
        });
    }

    public function completed()
    {
        $this->update(['status' => true]);
    }

    public function incomplete()
    {
        $this->update(['status' => false]);
    }
}
