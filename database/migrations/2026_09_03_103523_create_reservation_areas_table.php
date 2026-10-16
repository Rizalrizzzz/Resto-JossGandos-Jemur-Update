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
        Schema::create('reservation_areas', function (Blueprint $table) {
            $table->id();

            // URL / PATH GAMBAR AREA
            $table->string('image', 500)->nullable();

            // JUDUL AREA
            $table->string('title')->nullable();

            // DESKRIPSI AREA
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
        Schema::dropIfExists('reservation_areas');
    }
};
