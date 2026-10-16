<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GallerySetting extends Model
{
    protected $table = 'gallery_settings';

    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_description',
        'hero_image',

        // Bingkai 1
        'frame_1_image',
        'frame_1_description',

        // Bingkai 2
        'frame_2_image',
        'frame_2_description',

        // CTA Instagram
        'cta_title',
        'cta_description',
        'cta_button_1_link',

        // CTA WhatsApp
        'cta_button_2_link',
        'cta_whatsapp_title',
        'cta_whatsapp_description',
    ];
}
