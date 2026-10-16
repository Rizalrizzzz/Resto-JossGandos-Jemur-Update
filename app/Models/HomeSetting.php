<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $table = 'home_settings';

    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_subtitle',

        'welcome_badge',
        'welcome_title',
        'welcome_description',
        'welcome_quote',
        'welcome_image',

        'dish_badge',
        'dish_title',
        'dish_description',
        'dish_image',
        'dish_button_text',
        'dish_button_link',

        'cta_title',
        'cta_description',
        'cta_button_1_text',
        'cta_button_1_link',
        'cta_button_2_text',
        'cta_button_2_link',
    ];
}
