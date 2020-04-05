<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',

            'roles-list',
            'roles-create',
            'roles-edit',
            'roles-delete',

            'customer-list',
            'customer-create',
            'customer-edit',
            'customer-delete',

            'maps-list',
            'maps-create',
            'maps-edit',
            'maps-delete',
        ];

        foreach ($permissions as $permission) {
            $db_permission = Permission::whereName($permission)->first();
            if(empty($db_permission)){
                Permission::create(['name' => $permission, 'guard_name' => 'employee']);
            }
        }

        $roles = [
            'superadmin',
            'admin'
        ];
        foreach($roles as $item) {
            $role = Role::where('name', $item)->first();
            if(empty($role)){
                $role = Role::create(['name' => $item, 'guard_name' => 'employee']);
            }
            $role->syncPermissions($permissions);
        }
        
    }
}
