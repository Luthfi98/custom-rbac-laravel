<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Insert data into the menus table
        DB::table('menus')->insert([
            [
                'id' => 1,
                'parent_id' => NULL,
                'module' => 'module-setting',
                'name' => 'Setting',
                'path' => '#',
                'icon' => '#',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 1,
                'created_at' => '2023-11-25 09:37:50',
                'updated_at' => '2023-11-25 09:37:50',
                'deleted_at' => NULL,
            ],
            [
                'id' => 2,
                'parent_id' => 1,
                'module' => 'module-general-setting',
                'name' => 'General Setting',
                'path' => '#',
                'icon' => 'fa fa-cogs',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:38:27',
                'updated_at' => '2023-11-25 09:38:27',
                'deleted_at' => NULL,
            ],
            [
                'id' => 3,
                'parent_id' => 2,
                'module' => 'module-website',
                'name' => 'Web Setting',
                'path' => 'website.index',
                'icon' => 'fa fa-globe',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:40:13',
                'updated_at' => '2023-11-25 09:40:13',
                'deleted_at' => NULL,
            ],
            [
                'id' => 4,
                'parent_id' => 1,
                'module' => 'module-management-user',
                'name' => 'Management User',
                'path' => '#',
                'icon' => 'fa fa-users',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:41:35',
                'updated_at' => '2023-11-25 09:41:35',
                'deleted_at' => NULL,
            ],
            [
                'id' => 5,
                'parent_id' => 4,
                'module' => 'module-role',
                'name' => 'Role',
                'path' => 'roles.index',
                'icon' => '#',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:42:18',
                'updated_at' => '2023-11-25 09:42:18',
                'deleted_at' => NULL,
            ],
            [
                'id' => 6,
                'parent_id' => 4,
                'module' => 'module-user',
                'name' => 'User System',
                'path' => 'users.index',
                'icon' => 'fa fa-user-tie',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:43:00',
                'updated_at' => '2023-11-25 09:43:00',
                'deleted_at' => NULL,
            ],
            [
                'id' => 7,
                'parent_id' => 1,
                'module' => 'module-management-menu',
                'name' => 'Management Menu',
                'path' => '#',
                'icon' => 'fa fa-list',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:43:21',
                'updated_at' => '2023-11-25 09:43:21',
                'deleted_at' => NULL,
            ],
            [
                'id' => 8,
                'parent_id' => 7,
                'module' => 'module-menu',
                'name' => 'Menu System',
                'path' => 'menus.index',
                'icon' => 'fa fa-list',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:44:07',
                'updated_at' => '2023-11-25 09:44:07',
                'deleted_at' => NULL,
            ],
            [
                'id' => 9,
                'parent_id' => 7,
                'module' => 'module-sorting-menu',
                'name' => 'Sorting Menu',
                'path' => 'menus.sorting',
                'icon' => 'fa fa-sort',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:45:04',
                'updated_at' => '2023-11-25 09:45:04',
                'deleted_at' => NULL,
            ],
            [
                'id' => 10,
                'parent_id' => 7,
                'module' => 'module-permission',
                'name' => 'Permission',
                'path' => 'permissions.index',
                'icon' => 'fa fa-lock',
                'sort' => 0,
                'type' => 'cms',
                'is_label' => 0,
                'created_at' => '2023-11-25 09:45:50',
                'updated_at' => '2023-11-25 09:45:50',
                'deleted_at' => NULL,
            ],
        ]);
    }
}
