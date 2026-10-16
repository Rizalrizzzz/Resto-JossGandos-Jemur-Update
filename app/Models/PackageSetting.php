<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageSetting extends Model
{
    protected $fillable = [
        'section_title',
        'section_description',
        'cta_title',
        'cta_description',
    ];
}