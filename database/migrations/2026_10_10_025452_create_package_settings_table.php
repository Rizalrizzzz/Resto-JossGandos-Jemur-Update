<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_settings', function (Blueprint $table) {
            $table->id();

            // Header Section
            $table->string('section_title')
                ->default('Paket & Layanan');

            $table->text('section_description')->nullable();

            // CTA Konsultasi
            $table->string('cta_title')->nullable();
            $table->text('cta_description')->nullable();

            $table->timestamps();
        });

        // Data awal
        DB::table('package_settings')->insert([
            'section_title' => 'Paket & Layanan',
            'section_description' =>
                'Pilihan paket untuk berbagai kebutuhan acara.',
            'cta_title' =>
                'Butuh paket khusus atau ingin konsultasi?',
            'cta_description' =>
                'Hubungi kami untuk mendapatkan penawaran terbaik sesuai kebutuhan acara Anda.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('package_settings');
    }
};