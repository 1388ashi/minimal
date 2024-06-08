<?php

namespace Modules\Permission\App\Enums;

enum RolesEnum: string
{
    // case NAMEINAPP = 'name-in-database';

    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            RolesEnum::SUPER_ADMIN => 'Super Admin',
            RolesEnum::ADMIN => 'Admin',
        };
    }
}
