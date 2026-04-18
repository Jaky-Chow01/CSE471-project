<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'blood_type',
        'bags',
        'donation_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
