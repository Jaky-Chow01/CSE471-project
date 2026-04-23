<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bloodrequests extends Model
{
    use HasFactory;

    protected $table = 'bloodrequests';

    protected $fillable = [
        'urgent',
        'bloodgroup',
        'location',
        'datetime',
        'noofbags',
        'patienttype',
        'patientage',
        'patientgender',
        'contactno',
        'latitude',
        'longitude',
    ];
}
