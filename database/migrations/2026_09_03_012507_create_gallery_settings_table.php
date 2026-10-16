<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gallery_settings', function (Blueprint $table) {
            $table->id();

            // =========================
            // HERO GALLERY
            // =========================
            $table->string('hero_badge', 100)->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image', 500)->nullable();

            // =========================
            // CTA INSTAGRAM
            // =========================
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_button_1_link', 500)->nullable();

            // =========================
            // CTA WHATSAPP
            // =========================
            $table->string('cta_button_2_link', 500)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gallery_settings');
    }
};
