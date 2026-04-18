<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bloodtype extends Model
{
    
    protected $table = 'bloodtypes'; 

    public $timestamps = false;
    protected $primaryKey = 'blood_group'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [

        'blood_group', 
        'antigens_on_RBC', 
        'antibodies_in_plasma', 
        'can_donate_to', 
        'can_receive_from'
    ];
}