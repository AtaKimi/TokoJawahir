<?php

use App\Enum\BuyBackStatus;
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
        Schema::create('buy_backs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->enum('status', array_column(BuyBackStatus::cases(), 'value'))->default(BuyBackStatus::PENDING);
            $table->integer('total')->min(0)->default(0);
            $table->integer('total_sold')->min(0)->default(0);
            $table->integer('total_reduction')->min(0)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_backs');
    }
};
