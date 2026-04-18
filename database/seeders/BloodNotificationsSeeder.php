<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BloodNotificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('blood_notifications')->insert([
            ['stage' => 1, 'channel' => 'sms',   'message' => 'Your blood donation request has been received. We will notify you shortly.', 'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 2, 'channel' => 'email', 'message' => 'A matching donor has been found for your blood request. Please check the app.', 'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 3, 'channel' => 'push',  'message' => 'Your donation has been confirmed. Thank you for saving a life!',               'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 1, 'channel' => 'sms',   'message' => 'Emergency blood request nearby. AB+ blood needed urgently.',                   'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 2, 'channel' => 'push',  'message' => 'Reminder: You are eligible to donate blood again. Schedule your donation.',    'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['stage' => 1, 'channel' => 'email', 'message' => 'Thank you for registering as a donor on BloodConnect.',                        'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 3, 'channel' => 'sms',   'message' => 'Your NID verification is complete. Your donor profile is now active.',         'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 2, 'channel' => 'push',  'message' => 'Blood donation camp near you on April 20th. Tap to register.',                 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['stage' => 1, 'channel' => 'email', 'message' => 'O- blood urgently needed at Chittagong Medical College.',                      'status' => 'sent',    'created_at' => now(), 'updated_at' => now()],
            ['stage' => 3, 'channel' => 'sms',   'message' => 'Your blood request has been fulfilled. Please rate your experience.',          'status' => 'failed',  'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
