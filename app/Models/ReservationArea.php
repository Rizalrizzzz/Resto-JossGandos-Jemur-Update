<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationArea extends Model
{
    protected $table = 'reservation_areas';

    protected $fillable = [
        'image',
        'title',
        'description',
        'sort_order',
    ];
}
