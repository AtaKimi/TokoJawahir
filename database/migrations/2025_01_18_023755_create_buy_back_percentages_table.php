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
        Schema::create('buy_back_percentages', function (Blueprint $table) {
            $table->id();
            $table->integer('percentage')->min(1)->max(100);
            $table->timestamps();
        });

        Schema::table('buy_backs', function (Blueprint $table) {
            $table->foreignId('buy_back_percentage_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_back_percentages');
    }
};
