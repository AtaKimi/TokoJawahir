<?php

namespace App\Models;

use App\Actions\Traits\HasFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Jewellery extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\JewelleryFactory> */
    use HasFactory, InteractsWithMedia, HasFilter;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')->singleFile()->useDisk('public');
    }
}
