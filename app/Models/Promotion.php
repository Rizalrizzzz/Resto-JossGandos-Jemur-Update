<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'image_path',
        'link_url',
        'is_active',
        'sort_order',
        'is_home_popup',
        'home_start_at',
        'home_end_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'is_home_popup' => 'boolean',
        'home_start_at' => 'datetime',
        'home_end_at' => 'datetime',
    ];
}
