<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodNotification extends Model
{
    protected $table = 'blood_notifications';

    protected $fillable = ['stage', 'channel', 'message', 'status'];
}
