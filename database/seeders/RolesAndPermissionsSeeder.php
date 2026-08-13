<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage-users',
            'manage-roles',
            'manage-campaigns',
            'create-campaigns',
            'manage-donations',
            'view-donations',
            'manage-gateways',
            'view-financial-reports',
            'manage-volunteers',
            'manage-content',
            'manage-events',
            'manage-talents',
            'manage-settings',
            'view-logs',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        // Create Roles & Assign Permissions
        $superAdmin = Role::findOrCreate('Super Admin', 'web');
        $superAdmin->givePermissionTo(Permission::all());

        $campaignManager = Role::findOrCreate('Campaign Manager', 'web');
        $campaignManager->givePermissionTo(['manage-campaigns', 'create-campaigns', 'view-donations']);

        $contentManager = Role::findOrCreate('Content Manager', 'web');
        $contentManager->givePermissionTo(['manage-content', 'manage-events', 'manage-talents']);

        $financeOfficer = Role::findOrCreate('Finance Officer', 'web');
        $financeOfficer->givePermissionTo(['manage-donations', 'view-donations', 'view-financial-reports']);

        $volunteerCoordinator = Role::findOrCreate('Volunteer Coordinator', 'web');
        $volunteerCoordinator->givePermissionTo(['manage-volunteers', 'manage-events']);

        $supporter = Role::findOrCreate('Supporter', 'web');

        // Create Super Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gusiiallstars.org'],
            [
                'name' => 'Super Administrator',
                'phone' => '+254712345678',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
            ]
        );
        $admin->assignRole('Super Admin');

        // Create Campaign Manager User
        $cmpUser = User::firstOrCreate(
            ['email' => 'campaigns@gusiiallstars.org'],
            [
                'name' => 'Campaign Manager',
                'phone' => '+254722000111',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
            ]
        );
        $cmpUser->assignRole('Campaign Manager');

        // Create Finance Officer User
        $finUser = User::firstOrCreate(
            ['email' => 'finance@gusiiallstars.org'],
            [
                'name' => 'Finance Officer',
                'phone' => '+254733000222',
                'password' => Hash::make('Password123!'),
                'status' => 'active',
            ]
        );
        $finUser->assignRole('Finance Officer');
    }
}
