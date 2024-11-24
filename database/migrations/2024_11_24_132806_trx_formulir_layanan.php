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
        Schema::create('trx_formulir_layanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulir_id');
            $table->unsignedBigInteger('layanan_id');
            $table->timestamps();

            $table->foreign('formulir_id')->references('id')->on('trx_formulir')->cascadeOnDelete();
            $table->foreign('layanan_id')->references('id')->on('ref_layanan')->cascadeOnDelete();
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
