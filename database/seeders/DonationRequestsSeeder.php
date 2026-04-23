<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DonationRequestsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('donation_requests')->insert([
            [
                'stage'           => 1,
                'donor_token'     => Str::random(32),
                'requester_token' => Str::random(32),
                'created_at'      => now(),
                'updated_at'      => now(),
            ],
        ]);
    }
}
