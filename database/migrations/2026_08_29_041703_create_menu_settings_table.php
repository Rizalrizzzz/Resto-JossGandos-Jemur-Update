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
        Schema::create('menu_settings', function (Blueprint $table) {
            $table->id();

            // ==========================================
            // HERO / HEADER MENU
            // ==========================================
            $table->string('hero_badge')->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image', 500)->nullable();

            // ==========================================
            // PROMO
            // ==========================================
            $table->string('promo_title')->nullable();
            $table->text('promo_description')->nullable();

            // ==========================================
            // REKOMENDASI
            // ==========================================
            $table->string('recommended_title')->nullable();
            $table->text('recommended_description')->nullable();

            // ==========================================
            // MENU LAINNYA
            // ==========================================
            $table->string('menu_title')->nullable();
            $table->text('menu_description')->nullable();

            // ==========================================
            // PAKET & LAYANAN
            // ==========================================
            $table->string('package_title')->nullable();
            $table->text('package_description')->nullable();

            // ==========================================
            // TIMESTAMP
            // ==========================================
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_settings');
    }
};
