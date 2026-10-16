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
        Schema::create('reservation_terms', function (Blueprint $table) {
            $table->id();

            // IKON
            // Bisa berupa URL ikon atau path file ikon
            $table->string('icon', 500)->nullable();

            // JUDUL
            $table->string('title')->nullable();

            // DESKRIPSI
            $table->text('description')->nullable();

            // URUTAN TAMPILAN
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_terms');
    }
};
