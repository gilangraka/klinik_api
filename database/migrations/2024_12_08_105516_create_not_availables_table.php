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
        Schema::create('not_availables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('formulir_id')->nullable();
            $table->timestamp('start_time');
            $table->timestamp('end_time');

            $table->foreign('formulir_id')->references('id')->on('trx_formulir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('not_availables');
    }
};
