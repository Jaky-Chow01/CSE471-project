<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Donor;

class DonorSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Ahmed Karim', 'Jaky Ahmed', 'Sara Islam', 'Tanvir Hossain',
            'Anika Tabassum', 'Fahad Rahman', 'Sadia Afrin', 'Imtiaz Uddin',
            'Raisa Khan', 'Kamal Pasha', 'Zayan Malik', 'Mim Akter',
            'Karim Ullah', 'Rahim Sheikh', 'Nabil Ahmed', 'Farhan Ishraq',
            'Sumaiya Jaman', 'Habib Wahid', 'Luna Sarker', 'Arif Rayhan',
        ];

        $groups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];

        foreach (range(0, 19) as $i) {
            Donor::create([
                'name'        => $names[$i],
                'blood_group' => $groups[$i % 8],
                'latitude'    => 23.75 + ($i * 0.005),
                'longitude'   => 90.38 + ($i * 0.005),
                'status'      => 'Available',
            ]);
        }
    }
}
