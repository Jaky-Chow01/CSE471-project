<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class diagonosticcenters extends Model
{
    
    
    protected $table = 'diagonosticcenters'; 

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
