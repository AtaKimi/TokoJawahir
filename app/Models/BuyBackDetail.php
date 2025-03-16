<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyBackDetail extends Model
{
    /** @use HasFactory<\Database\Factories\BuyBackDetailFactory> */
    use HasFactory;

    protected $fillable = [
        'buy_back_id',
        'transaction_detail_id',
        'quantity',
        'total',
        'total_sold',
    ];


    public function buyBack()
    {
        return $this->belongsTo(BuyBack::class);
    }

    public function transactionDetail()
    {
        return $this->belongsTo(TransactionDetail::class);
    }
}
