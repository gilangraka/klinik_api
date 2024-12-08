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
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulir_id');
            $table->string('external_id');
            $table->decimal('amount');
            $table->string('checkout_link');
            $table->string('status')->nullable();
            $table->string('payment_method')->nullable();
            $table->timestamps();

            $table->foreign('formulir_id')->references('id')->on('formulir')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
