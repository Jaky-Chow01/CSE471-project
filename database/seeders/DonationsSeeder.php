<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DonationsSeeder extends Seeder
{
    
    public function run(): void
    {
        $user1 = User::updateOrCreate(
            ['email' => 'nafi@example.com'],
            [
                'name' => 'Nafi',
                'password' => bcrypt('password'),
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'sazid@example.com'],
            [
                'name' => 'Sazidul Alam',
                'password' => bcrypt('password'),
            ]
        );

        Donation::create([
            'user_id' => $user1->id,
            'blood_type' => 'A+',
            'bags' => 2,
            'donation_date' => now()->subDays(10),
        ]);

        Donation::create([
            'user_id' => $user1->id,
            'blood_type' => 'A+',
            'bags' => 1,
            'donation_date' => now()->subDays(5),
        ]);

        Donation::create([
            'user_id' => $user2->id,
            'blood_type' => 'O-',
            'bags' => 3,
            'donation_date' => now()->subDays(20),
        ]);

    }
}
