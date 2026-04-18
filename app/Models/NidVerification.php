<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NidVerification extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'nid_number', 'image_path',
        'status', 'verified_by', 'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
