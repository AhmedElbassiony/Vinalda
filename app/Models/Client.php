<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name' , 'mobile' , 'address' , 'governorate_id'];

    public function governorate()
    {
        return $this->belongsTo(Governorate::class , 'governorate_id' , 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class , 'client_id', 'id');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class , 'client_id', 'id');
    }
}
