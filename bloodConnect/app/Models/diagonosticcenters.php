<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class diagonosticcenters extends Model
{
    protected $table = 'diagonosticcenters';

    protected $fillable = [
        'name',
        'description',
        'location',
        'contactno',
        'services',
        'prices',
        'operating_hours',
        'emergency_services',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'services' => 'array',
        'prices' => 'array',
        'emergency_services' => 'boolean'
    ];
}
