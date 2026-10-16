<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeaderSetting extends Model
{
    protected $fillable = ['video_type', 'youtube_id', 'tiktok_url', 'video_path'];
}
