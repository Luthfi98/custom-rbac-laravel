<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the existing records to start from scratch
        DB::table('permissions')->truncate();

        // Insert data into the permissions table
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'menu_id' => 1,
                'prefix' => 'setting',
                'name' => 'module-setting-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 2,
                'menu_id' => 2,
                'prefix' => 'general-setting',
                'name' => 'module-general-setting-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 3,
                'menu_id' => 3,
                'prefix' => 'web-setting',
                'name' => 'module-website-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 4,
                'menu_id' => 3,
                'prefix' => 'web-setting',
                'name' => 'module-website-read',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 5,
                'menu_id' => 3,
                'prefix' => 'web-setting',
                'name' => 'module-website-update',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 6,
                'menu_id' => 4,
                'prefix' => 'management-user',
                'name' => 'module-management-user-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 7,
                'menu_id' => 5,
                'prefix' => 'role',
                'name' => 'module-role-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 8,
                'menu_id' => 5,
                'prefix' => 'role',
                'name' => 'module-role-read',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 9,
                'menu_id' => 5,
                'prefix' => 'role',
                'name' => 'module-role-create',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 10,
                'menu_id' => 5,
                'prefix' => 'role',
                'name' => 'module-role-update',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 11,
                'menu_id' => 5,
                'prefix' => 'role',
                'name' => 'module-role-delete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 12,
                'menu_id' => 5,
                'prefix' => 'role',
                'name' => 'module-role-access',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 13,
                'menu_id' => 6,
                'prefix' => 'user-system',
                'name' => 'module-user-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 14,
                'menu_id' => 6,
                'prefix' => 'user-system',
                'name' => 'module-user-read',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 15,
                'menu_id' => 6,
                'prefix' => 'user-system',
                'name' => 'module-user-create',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 16,
                'menu_id' => 6,
                'prefix' => 'user-system',
                'name' => 'module-user-update',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 17,
                'menu_id' => 6,
                'prefix' => 'user-system',
                'name' => 'module-user-delete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 18,
                'menu_id' => 7,
                'prefix' => 'management-menu',
                'name' => 'module-management-menu-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 19,
                'menu_id' => 8,
                'prefix' => 'menu-system',
                'name' => 'module-menu-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 20,
                'menu_id' => 8,
                'prefix' => 'menu-system',
                'name' => 'module-menu-read',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 21,
                'menu_id' => 8,
                'prefix' => 'menu-system',
                'name' => 'module-menu-create',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 22,
                'menu_id' => 8,
                'prefix' => 'menu-system',
                'name' => 'module-menu-update',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 23,
                'menu_id' => 8,
                'prefix' => 'menu-system',
                'name' => 'module-menu-delete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 24,
                'menu_id' => 9,
                'prefix' => 'sorting-menu',
                'name' => 'module-sorting-menu-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 25,
                'menu_id' => 9,
                'prefix' => 'sorting-menu',
                'name' => 'module-sorting-menu-read',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 26,
                'menu_id' => 9,
                'prefix' => 'sorting-menu',
                'name' => 'module-sorting-menu-update',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 27,
                'menu_id' => 10,
                'prefix' => 'permission',
                'name' => 'module-permission-show',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 28,
                'menu_id' => 10,
                'prefix' => 'permission',
                'name' => 'module-permission-read',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 29,
                'menu_id' => 10,
                'prefix' => 'permission',
                'name' => 'module-permission-create',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 30,
                'menu_id' => 10,
                'prefix' => 'permission',
                'name' => 'module-permission-update',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
            [
                'id' => 31,
                'menu_id' => 10,
                'prefix' => 'permission',
                'name' => 'module-permission-delete',
                'created_at' => NULL,
                'updated_at' => NULL,
            ],
        ]);
    }
}
