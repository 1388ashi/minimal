<?php

namespace Modules\Permission\Models;

use Modules\Core\App\Exceptions\ModelCannotBeDeletedException;
use Modules\Core\Traits\HasCache;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends SpatieRole
{
    use  HasCache,LogsActivity;
    const SUPER_ADMIN = 'super_admin';

    protected $fillable = [
        'name',
        'label',
        'guard_name'
    ];

    public array $sortable = [
        'id',
        'name',
        'label',
        'created_at',
    ];
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" نقش با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }

    public function isDeletable(): bool
    {
        return ($this->attributes['name'] !== static::SUPER_ADMIN) ||
            !$this->users()->exists();
    }

    public static function booted(): void
    {
        static::deleting(function (Role $role) {
            $superAdmin = static::SUPER_ADMIN;
            if ($role->name === $superAdmin) {
                throw new ModelCannotBeDeletedException("نقش {$superAdmin} قابل حذف نمی باشد.");
            }
            if ($role->users()->exists()) {
                throw new ModelCannotBeDeletedException("نقش {$superAdmin} به کاربر یا کاربرانی نسبت داده شده و قابل حذف نمی باشد.");
            }
        });

        static::clearAllCaches(['roles']);
    }
}
