<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Remove all users
        User::truncate();

        // Create roles if they don't exist
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123')
        ]);

        // Assign roles to the admin user
        $admin->assignRole($adminRole);
        $admin->assignRole($editorRole); // Optional: Assign multiple roles if needed

        // Create Alice
        $alice = User::create([
            'name' => 'Alice',
            'email' => 'alice@gmail.com',
            'password' => bcrypt('password123')
        ]);
        $alice->assignRole($userRole); // Assign user role

        // Create Bob
        $bob = User::create([
            'name' => 'Bob',
            'email' => 'bob@gmail.com',
            'password' => bcrypt('password123')
        ]);
        $bob->assignRole($userRole); // Assign user role
    }
}
