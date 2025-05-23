
<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $adminRole = Role::createRole('Administrator', 'System administrator with full access');
        $userRole = Role::createRole('User', 'Standard user with limited access');
        $managerRole = Role::createRole('Manager', 'Manager with elevated permissions');

        // Create a sample admin user
        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123')
        ]);

        // Assign admin role
        $adminUser->assignRole($adminRole);

        // Create a sample regular user
        $regularUser = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123')
        ]);

        // Assign user role
        $regularUser->assignRole($userRole);
    }
}
