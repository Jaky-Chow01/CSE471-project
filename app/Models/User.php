<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function totalDonations()
    {
        return $this->donations()->sum('bags');
    }

    public function nidVerification()
    {
        return $this->hasOne(NidVerification::class);
    }

    public function donationRequests()
    {
        return $this->hasMany(DonationRequest::class);
    }

    public function isAdmin(): bool    { return $this->role === 'admin'; }
    public function isDonor(): bool    { return $this->role === 'donor'; }
    public function isRequester(): bool { return $this->role === 'requester'; }
}
