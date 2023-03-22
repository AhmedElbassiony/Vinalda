<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name' , 'code' , 'purchase_price' , 'sale_price' , 'category_id' , 'brand_id' , 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class , 'category_id' , 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class , 'brand_id' , 'id');
    }

    public static function boot()
    {
        parent::boot();
        static::created(function (Item $item) {
            $item->code = "ITM" . str_pad($item->id, 4, 0, STR_PAD_LEFT);
            $item->save();
        });
    }
}
