<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        Permission::create(['name' => 'create articles']);
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);

        // Get the admin role
        $adminRole = Role::where('name', 'admin')->first();

        // Assign all permissions to admin role
        $adminRole->givePermissionTo([
            'create articles',
            'edit articles',
            'delete articles'
        ]);
    }
}
