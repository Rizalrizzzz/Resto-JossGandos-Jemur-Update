<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WelcomeFeature extends Model
{
    protected $table = 'welcome_features';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
