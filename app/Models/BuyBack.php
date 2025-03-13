<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyBack extends Model
{
    /** @use HasFactory<\Database\Factories\BuyBackFactory> */
    use HasFactory;

    protected $fillable = [
        'status',
        'user_id',
        'total',
        'buy_back_percentage_id',
    ];

    public function buyBackDetails()
    {
        return $this->hasMany(BuyBackDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
