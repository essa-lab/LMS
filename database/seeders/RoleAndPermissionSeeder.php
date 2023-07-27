<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::create(['name'=>'create-users']);
        Permission::create(['name'=>'delete-users']);
        Permission::create(['name'=>'edit-users']);

        Permission::create(['name' => 'create-course']);
        Permission::create(['name' => 'edit-course']);
        Permission::create(['name' => 'delete-course']);

        Permission::create(['name' => 'view-course']);

        $adminRole = Role::create(['name' => 'Admin']);
        $editorRole = Role::create(['name' => 'Editor']);
        $studentRole = Role::create(['name'=>'student']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-course',
            'edit-course',
            'delete-course',
        ]);

        $editorRole->givePermissionTo([
            'create-course',
            'edit-course',
            'delete-course',
        ]);

        $studentRole->givePermissionTo([
            'view-course',
        ]);
    }
}
