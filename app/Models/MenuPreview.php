<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuPreview extends Model
{
    protected $table = 'menu_previews';

    protected $fillable = [
        'image_path',
        'sort_order',
        'is_active',
    ];
}