<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bloodbanks extends Model
{
    protected $table = 'bloodbanks'; 

    public $timestamps = false;
    protected $primaryKey = 'name'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [

        'name', 
        'location', 
        'contactno'
    ];
}
