<?php

namespace App\Models;

use App\Enum\BuyBackStatus;
use Illuminate\Database\Eloquent\Model;
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

    public function buyBackQuantityLeft(){
        $buy_back_details = $this->buyBackDetails()->withWhereHas('buyBack', function ($query) {
            return $query->where('status', '!=', BuyBackStatus::PENDING);
        })->get();
        return $this->quantity - $buy_back_details->sum('quantity');
    }
}
