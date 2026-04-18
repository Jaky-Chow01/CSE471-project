<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonorCareSeeder extends Seeder
{
    public function run(): void
    {
        
        $records = [];
        for ($donorId = 1; $donorId <= 10; $donorId++) {
            $records[] = [
                'donor_id'        => $donorId,
                'hydration_start' => '08:00:00',
                'hydration_end'   => '20:00:00',
                'rest_start'      => '09:00:00',
                'rest_end'        => '17:00:00',
                'nutrition_start' => '07:00:00',
                'nutrition_end'   => '21:00:00',
                'created_at'      => now(),
                'updated_at'      => now(),
            ];
        }

        DB::table('donor_care')->insert($records);
    }
}
