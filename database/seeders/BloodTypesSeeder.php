<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\bloodtype;

class BloodTypesSeeder extends Seeder
{
    
    public function run(): void
    {
        $bloodTypes = [
            [
                'blood_group' => 'A+',
                'antigens_on_RBC' => 'A',
                'antibodies_in_plasma' => 'Anti-B',
                'can_donate_to' => 'A+, AB+',
                'can_receive_from' => 'A+, A-, O+, O-',
            ],
            [
                'blood_group' => 'A-',
                'antigens_on_RBC' => 'A',
                'antibodies_in_plasma' => 'Anti-B',
                'can_donate_to' => 'A+, A-, AB+, AB-',
                'can_receive_from' => 'A-, O-',
            ],
            [
                'blood_group' => 'B+',
                'antigens_on_RBC' => 'B',
                'antibodies_in_plasma' => 'Anti-A',
                'can_donate_to' => 'B+, AB+',
                'can_receive_from' => 'B+, B-, O+, O-',
            ],
            [
                'blood_group' => 'B-',
                'antigens_on_RBC' => 'B',
                'antibodies_in_plasma' => 'Anti-A',
                'can_donate_to' => 'B+, B-, AB+, AB-',
                'can_receive_from' => 'B-, O-',
            ],
            [
                'blood_group' => 'AB+',
                'antigens_on_RBC' => 'A, B',
                'antibodies_in_plasma' => 'None',
                'can_donate_to' => 'AB+',
                'can_receive_from' => 'All blood types',
            ],
            [
                'blood_group' => 'AB-',
                'antigens_on_RBC' => 'A, B',
                'antibodies_in_plasma' => 'None',
                'can_donate_to' => 'AB+, AB-',
                'can_receive_from' => 'AB-, A-, B-, O-',
            ],
            [
                'blood_group' => 'O+',
                'antigens_on_RBC' => 'None',
                'antibodies_in_plasma' => 'Anti-A, Anti-B',
                'can_donate_to' => 'O+, A+, B+, AB+',
                'can_receive_from' => 'O+, O-',
            ],
            [
                'blood_group' => 'O-',
                'antigens_on_RBC' => 'None',
                'antibodies_in_plasma' => 'Anti-A, Anti-B',
                'can_donate_to' => 'All blood types',
                'can_receive_from' => 'O-',
            ],
        ];

        foreach ($bloodTypes as $type) {
            bloodtype::updateOrCreate(
                ['blood_group' => $type['blood_group']],
                $type
            );
        }
    }
}
