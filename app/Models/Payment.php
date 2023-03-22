<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'vendor_id',
        'bank_id',
        'bill_id',
        'expense_id',
        'date',
        'value',
        'description',
        'status',
        'received_date',
        'received_bank_id',
        'type',
        'transaction_date',
        'transaction_description',
    ];

    protected $casts = [
        'date' => 'date',
        'received_date' => 'date',
        'transaction_date' => 'datetime:Y-m-d H:i',
    ];

    public function scopeBankPayment($query , $type , $received_bank_id , $transaction_date)
    {
        return $query
            ->where('type', $type)
            ->where('received_bank_id' , $received_bank_id)
            ->where('status' , 1)
            ->where('transaction_date' , '<=' , $transaction_date)
            ->sum('value');
    }

    public function scopeBankTransactionTo($query , $type , $received_bank_id , $transaction_date)
    {
        return $query
            ->where('type', $type)
            ->where('received_bank_id' , $received_bank_id)
            ->where('status' , 1)
            ->where('transaction_date' , '<=' , $transaction_date)
            ->sum('value');
    }

    public function scopeBankTransactionFrom($query , $type , $bank_id , $transaction_date)
    {
        return $query
            ->where('type', $type)
            ->where('bank_id' , $bank_id)
            ->where('status' , 1)
            ->where('transaction_date' , '<=' , $transaction_date)
            ->sum('value');
    }

    public function client()
    {
        return $this->belongsTo(Client::class , 'client_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class , 'vendor_id', 'id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class , 'bank_id', 'id');
    }

    public function bill()
    {
        return $this->belongsTo(Bill::class , 'bill_id', 'id');
    }

    public function expense()
    {
        return $this->belongsTo(Expense::class , 'expense_id', 'id');
    }

    public function receivedBank()
    {
        return $this->belongsTo(Bank::class , 'received_bank_id', 'id');
    }
}
