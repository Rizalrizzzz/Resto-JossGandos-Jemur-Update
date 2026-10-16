<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappClick extends Model
{
    protected $fillable = [
        'page',
        'session_id',
        'ip_address',
    ];
}
