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
        Schema::create('trx_post', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->unsignedBigInteger('category_id');
            $table->string('thumbnail');
            $table->longText('content');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('ref_post_category')->cascadeOnDelete();
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
