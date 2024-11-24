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
        Schema::create('ref_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('jenis_layanan_id');
            $table->string('deskripsi');
            $table->integer('biaya');
            $table->timestamps();

            $table->foreign('jenis_layanan_id')->references('id')->on('ref_jenis_layanan')->cascadeOnDelete();
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
