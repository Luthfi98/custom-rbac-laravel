<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the existing records to start from scratch
        DB::table('roles')->truncate();

        // Insert data into the roles table
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Administrator',
                'description' => 'Super Admin',
                'status' => 'Active',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ],
        ]);
    }
}
