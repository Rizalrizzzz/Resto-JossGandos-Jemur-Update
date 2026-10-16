<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('welcome_features', function (Blueprint $table) {
            $table->id();

            // Ikon bisa berupa:
            // - path file upload, atau
            // - URL gambar
            $table->string('icon', 500)->nullable();

            // Judul item
            $table->string('title', 100);

            // Deskripsi singkat item
            $table->string('description', 255);

            // Status tampil/tidak
            $table->boolean('is_active')->default(true);

            // Urutan tampil di Home
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Batalkan migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('welcome_features');
    }
};
