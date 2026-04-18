<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostsSeeder extends Seeder
{
    
    public function run(): void
    {
        Post::create([
            'Description' => 'Join us for a blood donation camp at Dhaka University on April 20th. All blood types are welcome. Help save lives!',
            'image' => 'donation_camp.jpg',
        ]);

        Post::create([
            'Description' => 'Emergency situation at Chittagong Medical College. O- blood donors please contact immediately.',
            'image' => 'emergency.jpg',
        ]);

        Post::create([
            'Description' => 'Excited to announce the launch of BloodConnect app! Connect with donors instantly and save lives.',
            'image' => 'app_launch.jpg',
        ]);
    }
}
