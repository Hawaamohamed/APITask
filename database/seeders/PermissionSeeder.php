<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->truncatePermissionTables();
        $this->command->info('Truncating  Role and Permission tables and admins');
        $this->truncatePermissionTables();

        $mapPermission = collect(getPermissionsMap());
        $modules = getAllMolesWithPermissions();
        $all_permission_created = [];

        // Reading  permission modules
        foreach ($modules as $module => $value) {

            foreach (explode(',', $value) as $p => $perm) {
                $permissionValue = $mapPermission->get($perm);

                // create permissions
                $permission = Permission::create(['name' => $permissionValue . '_' . $module, 'guard_name' => 'admin']);
                $this->command->info('Creating Permission to ' . $permissionValue . ' for ' . $module);
                array_push($all_permission_created, $permission->id);
            }

        }


        //create super admin
        $super_admin = \App\Models\User::create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'phone' => '+201128939648',
                'password' => bcrypt('123456'),
            ]);

        //assignRole super-admin
        $role = Role::findOrCreate('super_admin', 'admin');
        // Adding permissions via a role
        $super_admin->assignRole($role);
//        $super_admin->syncPermissions($all_permission_created);

    }


    /**
     * Truncates all the permission tables and the users table
     *
     * @return    void
     */
    public
    function truncatePermissionTables()
    {
        Schema::disableForeignKeyConstraints();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        DB::table('users')->truncate();
        Schema::enableForeignKeyConstraints();
    }
}
