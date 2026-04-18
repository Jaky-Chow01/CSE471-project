<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\bloodrequests;
use App\Models\User;

class BloodRequestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        bloodrequests::create([
            'urgent' => 'Urgent',
            'bloodgroup' => 'A+',
            'location' => 'Dhaka Medical College Hospital, Dhaka',
            'datetime' => now()->addDays(1),
            'noofbags' => 2,
            'patienttype' => 'Adult',
            'patientage' => 45,
            'patientgender' => 'Male',
            'contactno' => '+8801712345678',
        ]);

        bloodrequests::create([
            'urgent' => '',
            'bloodgroup' => 'O-',
            'location' => 'Square Hospital, Dhaka',
            'datetime' => now()->addDays(2),
            'noofbags' => 1,
            'patienttype' => 'Child',
            'patientage' => 10,
            'patientgender' => 'Female',
            'contactno' => '+8801812345678',
        ]);

        bloodrequests::create([
            'urgent' => 'Urgent',
            'bloodgroup' => 'B+',
            'location' => 'United Hospital, Dhaka',
            'datetime' => now(),
            'noofbags' => 3,
            'patienttype' => 'Adult',
            'patientage' => 30,
            'patientgender' => 'Male',
            'contactno' => '+8801912345678',
        ]);
    }
}