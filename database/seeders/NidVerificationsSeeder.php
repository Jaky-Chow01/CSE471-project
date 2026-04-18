<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NidVerificationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('nid_verifications')->insert([
            ['nid_number' => '1991234567890', 'status' => 'verified',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1989876543210', 'status' => 'verified',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1995112233445', 'status' => 'pending',   'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1987665544332', 'status' => 'verified',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1993001122334', 'status' => 'verified',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1990445566778', 'status' => 'rejected',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1994889900112', 'status' => 'pending',   'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1988223344556', 'status' => 'verified',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1992556677889', 'status' => 'verified',  'created_at' => now(), 'updated_at' => now()],
            ['nid_number' => '1996334455667', 'status' => 'pending',   'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
