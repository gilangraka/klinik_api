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
        Schema::create('trx_formulir', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('usia');
            $table->string('email');
            $table->enum('gender', ['laki-laki', 'perempuan']);
            $table->string('nomor_hp');
            $table->string('alamat');
            $table->string('keluhan');
            $table->timestamp('datetime');
            $table->string('lokasi')->nullable();
            $table->integer('is_done')->default(0);
            $table->timestamps();
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
