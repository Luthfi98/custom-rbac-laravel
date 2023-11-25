<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the existing records to start from scratch
        DB::table('user_roles')->truncate();

        // Insert data into the user_roles table
        DB::table('user_roles')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'role_id' => 1,
                'status' => 'Active',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ],
        ]);
    }
}
