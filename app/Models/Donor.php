<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $fillable = [
        'name', 'initials', 'blood_group', 'location',
        'latitude', 'longitude', 'phone', 'email',
        'last_donation', 'min_wait', 'availability_today', 'status', 'queue_processed_at',
    ];

    protected $casts = [
        'last_donation'     => 'date',
        'availability_today'=> 'boolean',
        'latitude'          => 'float',
        'longitude'         => 'float',
    ];
}
