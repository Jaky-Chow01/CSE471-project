<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@bloodconnect.com')],
            [
                'name'     => 'Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'hospital123')),
                'role'     => 'admin',
            ]
        );

        $this->call([
            BloodTypesSeeder::class,
            BloodBanksSeeder::class,
            DiagnosticCentersSeeder::class,
            BloodRequestsSeeder::class,
            DonorsSeeder::class,
            DonationsSeeder::class,
            DonationRequestsSeeder::class,
            NidVerificationsSeeder::class,
            BloodNotificationsSeeder::class,
            DonorCareSeeder::class,
            PostsSeeder::class,
        ]);
    }
}
