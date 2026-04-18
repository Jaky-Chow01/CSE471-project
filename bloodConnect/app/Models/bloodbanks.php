<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bloodbanks extends Model
{
    protected $table = 'bloodbanks';

    protected $fillable = [
        'name',
        'location',
        'contactno'
    ];
}
