<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'jewellery_id',
        'quantity',
        'total',
        'quantity_sold',
    ];

    public function jewellery()
    {
        return $this->belongsTo(Jewellery::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function buyBackDetails()
    {
        return $this->hasMany(BuyBackDetail::class);
    }

    protected function quantityLeft(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity - $this->quantity_sold
        );
    }
}
