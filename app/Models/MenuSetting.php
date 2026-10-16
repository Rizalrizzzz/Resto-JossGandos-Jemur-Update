<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSetting extends Model
{
    protected $table = 'menu_settings';

    protected $fillable = [
        'hero_badge',
        'hero_title',
        'hero_description',
        'hero_image',

        'promo_title',

        'recommended_title',

        'menu_title',

        'package_title',
        'package_description',

        // PACKAGE MENU
        'package_menu_icon',
        'package_menu_title',
        'package_menu_description',

        // BOX PACKAGE
        'box_package_icon',
        'box_package_title',
        'box_package_description',

        // WEDDING PACKAGE
        'wedding_package_icon',
        'wedding_package_title',
        'wedding_package_description',

        // CTA MENU LENGKAP
        'cta_image',
        'cta_badge',
        'cta_title',
        'cta_description',
        'cta_link',

    ];
}
