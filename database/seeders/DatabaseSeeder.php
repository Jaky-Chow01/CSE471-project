<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DonationRequest;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(DonorSeeder::class);

        // Seed a single global DonationRequest if none exists
        if (DonationRequest::count() === 0) {
            DonationRequest::create([
                'stage'           => 0,
                'donor_token'     => Str::random(32),
                'requester_token' => Str::random(32),
            ]);
        }
    }
}
