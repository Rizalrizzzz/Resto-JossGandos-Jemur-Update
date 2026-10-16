<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSetting extends Model
{
    use HasFactory;

    protected $table = 'about_settings';

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'hero_image',

        'story_title',
        'story_content',

        'vision',

        'founder_name',
        'founder_position',
        'founder_photo',
        'founder_description',
    ];
}
