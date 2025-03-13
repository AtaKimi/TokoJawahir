<?php

use App\Models\Jewellery;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('testing', function () {
    $jewellery = Jewellery::find(1);
    dd($jewellery->getMedia('image')[0]->getUrl());
});