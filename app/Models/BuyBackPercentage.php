<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyBackPercentage extends Model
{
    /** @use HasFactory<\Database\Factories\BuyBackPercentageFactory> */
    use HasFactory;

    public function buyBacks()
    {
        return $this->hasMany(BuyBack::class);
    }
}
