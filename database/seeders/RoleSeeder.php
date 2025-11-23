<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create super_admin role
        $superAdmin = Role::updateOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );

        // Get all existing permissions
        $allPermissions = Permission::all();

        // Assign all permissions to super_admin role
        $superAdmin->syncPermissions($allPermissions);

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
        ]);

        $admin->assignRole($superAdmin);

        $this->command->info('Super Admin role created and all permissions assigned successfully!');
    }
}
