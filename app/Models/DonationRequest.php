<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    protected $fillable = ['stage', 'donor_token', 'requester_token', 'bloodrequest_id', 'user_id', 'donor_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donorUser()
    {
        return $this->belongsTo(User::class, 'donor_user_id');
    }

    public function bloodRequest()
    {
        return $this->belongsTo(\App\Models\bloodrequests::class, 'bloodrequest_id');
    }
}
