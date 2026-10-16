<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationSetting extends Model
{
    protected $table = 'reservation_settings';

    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_description',
        'hero_whatsapp_link',
        'hero_image',
        'response_time',

        'steps_title',
        'terms_title',
        'areas_title',
        'areas_subtitle',


        'location_name',
        'location_subtitle',
        'location_image',
        'address',
        'location_title',
        'operating_hours',
        'whatsapp_number',

        'instagram_link',
        'facebook_link',
        'tiktok_link',
        'whatsapp_link',

        'cta_badge',
        'cta_title',
        'cta_description',
        'cta_background_image',
        'cta_whatsapp_link',
    ];
}
