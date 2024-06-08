<?php

namespace App\Traits;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

trait HasPermission
{
    public function makeRoles()
    {
        Role::create([
        'name' => 'super_admin',
        'label' => 'مدیر ارشد',
        'guard_name' => 'web'
    ]);
    
    Role::create([
        'name' => 'admin',
        'label' => 'مدیر',
        'guard_name' => 'web'
        ]);
    }
    // public function createPermissions(array $permissions): array
    // {
    //     $permissionNames  = [];
    //     foreach ($permissions as $name => $label) {
    //         $permission = new Permission();
    //         $permission->name = $name;
    //         $permission->label = $label;
    //         $permission->guard_name = 'web';
    //         $permission->save();

    //         $permissionNames[] = $permission->name;
    //     }

    //     return $permissionNames;
    // }

    // public function assignPermissions(array $permissionNames, string $role): void
    // {
    //     $role = Role::query()->where('name', $role)->first();
    //     foreach ($permissionNames as $permissionName) {
    //         $role->givePermissionTo($permissionName);
    //     }
    // }
}