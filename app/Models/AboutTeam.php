<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutTeam extends Model
{
    use HasFactory;

    protected $table = 'about_teams';

    protected $fillable = [
        'name',
        'position',
        'photo',
        'description',
        'sort_order',
    ];
}
