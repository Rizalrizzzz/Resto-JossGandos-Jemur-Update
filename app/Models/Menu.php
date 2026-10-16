<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'image_path',
        'type',
        'category',
        'is_recommended',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
    ];
}
