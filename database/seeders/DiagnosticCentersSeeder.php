<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\diagonosticcenters;

  class DiagnosticCentersSeeder extends Seeder
{
    
    public function run(): void
    {
        diagonosticcenters::create([
            'name' => 'Popular Diagnostic Center',
            'description' => 'Comprehensive diagnostic services with modern equipment and experienced medical professionals',
            'location' => 'Dhanmondi, Dhaka',
            'contactno' => '+8801712345678',
            'services' => ['Blood Test', 'X-Ray', 'MRI', 'CT Scan', 'Ultrasound', 'ECG', 'ECHO', 'Endoscopy'],
            'prices' => [
                'Blood Test' => 500,
                'X-Ray' => 800,
                'Ultrasound' => 1200,
                'ECG' => 300,
                'ECHO' => 1500,
                'MRI' => 8000,
                'CT Scan' => 6000
            ],
            'operating_hours' => '8:00 AM - 10:00 PM',
            'emergency_services' => true
        ]);

        diagonosticcenters::create([
            'name' => 'Medinova Medical Services',
            'description' => 'Advanced diagnostic center with state-of-the-art technology and 24/7 emergency services',
            'location' => 'Gulshan, Dhaka',
            'contactno' => '+8801812345678',
            'services' => ['Blood Test', 'X-Ray', 'CT Scan', 'Ultrasound', 'ECG', 'Dental X-Ray', 'Mammography'],
            'prices' => [
                'Blood Test' => 450,
                'X-Ray' => 700,
                'Ultrasound' => 1000,
                'ECG' => 250,
                'CT Scan' => 5500,
                'Mammography' => 3000
            ],
            'operating_hours' => '7:00 AM - 11:00 PM',
            'emergency_services' => true
        ]);

        diagonosticcenters::create([
            'name' => 'Chittagong Diagnostic Center',
            'description' => 'Leading diagnostic center in Chittagong with comprehensive healthcare services',
            'location' => 'Agrabad, Chittagong',
            'contactno' => '+8801912345678',
            'services' => ['Blood Test', 'X-Ray', 'Ultrasound', 'ECG', 'ECHO', 'Colonoscopy', 'Biopsy'],
            'prices' => [
                'Blood Test' => 400,
                'X-Ray' => 600,
                'Ultrasound' => 900,
                'ECG' => 200,
                'ECHO' => 1200,
                'Colonoscopy' => 5000
            ],
            'operating_hours' => '8:00 AM - 8:00 PM',
            'emergency_services' => false
        ]);

        diagonosticcenters::create([
            'name' => 'Sylhet Medical Diagnostic',
            'description' => 'Modern diagnostic facilities serving the Sylhet region with quality healthcare',
            'location' => 'Zindabazar, Sylhet',
            'contactno' => '+8801612345678',
            'services' => ['Blood Test', 'X-Ray', 'Ultrasound', 'ECG', 'Dengue Test', 'Thyroid Test'],
            'prices' => [
                'Blood Test' => 350,
                'X-Ray' => 500,
                'Ultrasound' => 800,
                'ECG' => 180,
                'Dengue Test' => 800,
                'Thyroid Test' => 600
            ],
            'operating_hours' => '9:00 AM - 7:00 PM',
            'emergency_services' => false
        ]);
    }
}
