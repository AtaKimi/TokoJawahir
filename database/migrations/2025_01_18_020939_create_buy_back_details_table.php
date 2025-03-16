<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('buy_back_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buy_back_id')->constrained();
            $table->foreignId('transaction_detail_id')->constrained();
            $table->integer('quantity')->min(0)->default(0);
            $table->integer('total')->min(0)->default(0);
            $table->integer('total_sold')->min(0)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_back_details');
    }
};
