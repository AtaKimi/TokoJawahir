<?php

namespace App\Models;

use App\Enum\BuyBackStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
            get: fn() => $this->quantity - $this->quantity_sold
        );
    }
}
