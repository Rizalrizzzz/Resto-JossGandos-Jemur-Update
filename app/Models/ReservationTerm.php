<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservationTerm extends Model
{
    protected $table = 'reservation_terms';

    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort_order',
    ];
}
