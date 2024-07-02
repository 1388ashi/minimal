<?php

namespace Modules\Admin\Models;

use App\Traits\HasPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\Core\App\Exceptions\ModelCannotBeDeletedException;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Modules\Permission\Models\Role as modelRole;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory,HasRoles, HasPermission;

    /**
     * The attributes that are mass assignable.
     */
    public function getRole(): Role|null
    {
        return $this->roles->first();
    }


    protected $fillable = [
        'name',
        'password',
        'mobile',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function isDeletable(): bool
    {
        return !$this->getRole() || $this->getRole()->name !== modelRole::SUPER_ADMIN;
    }

    public static function booted(): void
    {
        static::deleting(function (Admin $admin) {
            if (!$admin->isDeletable()) {
                throw new ModelCannotBeDeletedException('این ادمین قابل حذف نمی باشد!');
            }
        });
    }

}
