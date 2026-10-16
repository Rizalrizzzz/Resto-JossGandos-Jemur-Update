<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTimeline extends Model
{
    use HasFactory;

    protected $table = 'about_timelines';

    protected $fillable = [
        'year',
        'title',
        'description',
        'sort_order',
    ];
}
