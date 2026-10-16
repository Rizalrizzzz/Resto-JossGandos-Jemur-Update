<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationStep extends Model
{
    protected $table = 'reservation_steps';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort_order',
    ];
}
