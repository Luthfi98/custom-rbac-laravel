<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Insert data into the users table
        DB::table('users')->insert([
            [
                'id' => 1,
                'fullname' => 'Luthfi Ihdahusnayain',
                'username' => 'luthfi.ih',
                'email' => 'luthfi.ihdalhusnayain98@gmail.com',
                'phone' => '0895322316585',
                'email_verified_at' => NULL,
                'password' => '$2y$10$iCbt/ldX4fmdx5EYs536XuktWC.gRDt50qzhlwKDosidP3ibOmdbu', // Hashed password
                'status' => 'Active',
                'image' => NULL,
                'remember_token' => NULL,
                'default_role' => 1,
                'theme_version' => 'light',
                'created_at' => '2023-11-25 09:33:48',
                'updated_at' => '2023-11-25 09:33:48',
                'deleted_at' => NULL,
            ],
        ]);
    }
}
