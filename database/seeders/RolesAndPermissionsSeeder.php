<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::findOrCreate('Super Admin');
        $adminRole = Role::findOrCreate('Admin');

        $manageUsers = Permission::findOrCreate('Manage Users');

        $adminRole->syncPermissions([
            $manageUsers,
        ]);
    }
}
