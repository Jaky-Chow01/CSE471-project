<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DonorsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('donors')->insert([
            ['name'=>'Arif Hossain',  'initials'=>'AH','blood_group'=>'A-', 'location'=>'124/ABC Road, Dhaka',           'latitude'=>23.8103,'longitude'=>90.4125,'phone'=>'01711-000001','email'=>'arif@gmail.com',   'last_donation'=>now()->subDays(98), 'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Bashir Ahmed',  'initials'=>'BA','blood_group'=>'AB+','location'=>'44/ABC Lane, Old Dhaka',         'latitude'=>23.7500,'longitude'=>90.3750,'phone'=>'01711-000002','email'=>'bashir@gmail.com', 'last_donation'=>now()->subDays(120),'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Chandra Mitra', 'initials'=>'CM','blood_group'=>'O-', 'location'=>'65/ABC Street, Wari, Dhaka',    'latitude'=>23.8200,'longitude'=>90.4000,'phone'=>'01711-000003','email'=>'chandra@gmail.com','last_donation'=>now()->subDays(60), 'min_wait'=>90,'availability_today'=>0,'status'=>'Unavailable','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Delwar Islam',  'initials'=>'DI','blood_group'=>'B+', 'location'=>'12/XYZ Colony, Dhaka',          'latitude'=>23.7800,'longitude'=>90.4200,'phone'=>'01711-000004','email'=>'delwar@gmail.com', 'last_donation'=>now()->subDays(200),'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ema Sultana',   'initials'=>'ES','blood_group'=>'O+', 'location'=>'88/Mirpur Road, Dhaka',         'latitude'=>23.8000,'longitude'=>90.3600,'phone'=>'01711-000005','email'=>'ema@gmail.com',    'last_donation'=>now()->subDays(150),'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Farhan Rahman', 'initials'=>'FR','blood_group'=>'A+', 'location'=>'Gulshan Avenue, Dhaka',         'latitude'=>23.7936,'longitude'=>90.4148,'phone'=>'01712-345678','email'=>'farhan@email.com', 'last_donation'=>now()->subDays(45), 'min_wait'=>90,'availability_today'=>0,'status'=>'Unavailable','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Rida Khanom',   'initials'=>'RK','blood_group'=>'B-', 'location'=>'Dhanmondi Road 27, Dhaka',      'latitude'=>23.7461,'longitude'=>90.3742,'phone'=>'01719-876543','email'=>'rida@email.com',   'last_donation'=>now()->subDays(97), 'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Sakib Hassan',  'initials'=>'SH','blood_group'=>'O+', 'location'=>'Uttara Sector 7, Dhaka',        'latitude'=>23.8759,'longitude'=>90.3795,'phone'=>'01815-112233','email'=>'sakib@email.com',  'last_donation'=>now()->subDays(130),'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Nadia Islam',   'initials'=>'NI','blood_group'=>'AB-','location'=>'Banani DOHS, Dhaka',            'latitude'=>23.7937,'longitude'=>90.4057,'phone'=>'01918-223344','email'=>'nadia@email.com',  'last_donation'=>now()->subDays(180),'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Karim Uddin',   'initials'=>'KU','blood_group'=>'B+', 'location'=>'Mohammadpur, Dhaka',            'latitude'=>23.7644,'longitude'=>90.3588,'phone'=>'01611-334455','email'=>'karim@email.com',  'last_donation'=>now()->subDays(75), 'min_wait'=>90,'availability_today'=>1,'status'=>'Available',  'created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}
