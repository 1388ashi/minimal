<?php

namespace Modules\Permission\Models;

use Modules\Admin\Models\Admin;
use Modules\Core\App\Exceptions\ModelCannotBeDeletedException;
use Modules\Core\Traits\HasCache;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends SpatieRole
{
    use  HasCache,LogsActivity;
    public const SUPER_ADMIN = 'super_admin';

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
		return !Admin::role($this->attributes['name'])->exists();
	}

	public static function booted(): void
	{
		static::deleting(function (Role $role) {
			$superAdmin = static::SUPER_ADMIN;
			if ($role->name === static::SUPER_ADMIN) {
				throw new ModelCannotBeDeletedException("نقش {$superAdmin} قابل حذف نمی باشد.");
			}
			if ($role->admins()->exists()) {
				throw new ModelCannotBeDeletedException("نقش {$role->label} به کاربر یا کاربرانی نسبت داده شده و قابل حذف نمی باشد.");
			}
		});
	}

	public function admins(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(
            Admin::class,
            'model_has_roles',
            'model_id',
            'role_id',
        );
    }
}
