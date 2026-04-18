<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\bloodbanks;

class BloodBanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        bloodbanks::create([
            'name' => 'Dhaka Medical College Blood Bank',
            'location' => 'Dhaka Medical College, Dhaka',
            'contactno' => '+88029126601',
        ]);

        bloodbanks::create([
            'name' => 'Bangabandhu Sheikh Mujib Medical University Blood Bank',
            'location' => 'BSMMU, Shahbag, Dhaka',
            'contactno' => '+88028610741',
        ]);

        bloodbanks::create([
            'name' => 'Chittagong Medical College Blood Bank',
            'location' => 'Chittagong Medical College, Chittagong',
            'contactno' => '+88031636801',
        ]);

        bloodbanks::create([
            'name' => 'Rajshahi Medical College Blood Bank',
            'location' => 'Rajshahi Medical College, Rajshahi',
            'contactno' => '+880721774301',
        ]);
    }
}