<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Clear existing roles and permissions
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create permissions
        $permissions = [
            'manage users',
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'manage categories'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        
        // User role
        $userRole = Role::create(['name' => 'user']);
        $userRole->givePermissionTo(['view articles']);

        // Author role
        $authorRole = Role::create(['name' => 'author']);
        $authorRole->givePermissionTo([
            'view articles',
            'create articles',
            'edit articles'
        ]);

        // Editor role
        $editorRole = Role::create(['name' => 'editor']);
        $editorRole->givePermissionTo([
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',
            'manage categories'
        ]);

        // Admin role
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());
    }
}
