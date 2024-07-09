<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('ua_UA');

        for ($i = 1; $i <= 45; $i++) {
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'email' => $faker->unique()->safeEmail,
                'photo' =>"https://i.ibb.co/8NfHx0d/2024-07-08-10-58-04-2024-07-06-09-16-56-pngtree-landscape-jpg-wallpapers-free-download-image-2573540.jpg",
                'phone' => "+380-".rand(100, 999)."-".rand(100, 999)."-".rand(100, 999),
                'position_id' => rand(1, 4),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
