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
        Schema::create('open_close_balances', function (Blueprint $table) {
            $table->id();
            $table->string('open_balance');
            $table->string('close_balance');
            $table->string('total_balance');
            $table->string('remarks');
            $table->unsignedBigInteger('exchange_id')->nullable();
            $table->foreign('exchange_id')->references('id')->on('exchanges')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_close_balances');
    }
};