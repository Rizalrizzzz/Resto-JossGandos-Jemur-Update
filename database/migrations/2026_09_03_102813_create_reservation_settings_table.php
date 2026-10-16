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
        Schema::create('reservation_settings', function (Blueprint $table) {
            $table->id();

            // =====================================================
            // HEADER
            // =====================================================
            $table->string('hero_badge', 100)->nullable();
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image', 500)->nullable();
            $table->string('response_time')->nullable();

            // =====================================================
            // LOKASI
            // =====================================================
            $table->string('location_name')->nullable();
            $table->string('location_subtitle')->nullable();
            $table->text('address')->nullable();
            $table->string('operating_hours')->nullable();
            $table->string('whatsapp_number')->nullable();

            // =====================================================
            // SOCIAL MEDIA
            // =====================================================
            $table->string('instagram_link', 500)->nullable();
            $table->string('facebook_link', 500)->nullable();
            $table->string('tiktok_link', 500)->nullable();
            $table->string('whatsapp_link', 500)->nullable();

            // =====================================================
            // CTA
            // =====================================================
            $table->string('cta_badge', 100)->nullable();
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();
            $table->string('cta_whatsapp_link', 500)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_settings');
    }
};
