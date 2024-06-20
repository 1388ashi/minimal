<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\BaseModel;
use Modules\Core\Traits\Filterable;
use Illuminate\Support\Facades\Cache;

class Ticket extends BaseModel
{
    use HasFactory, Filterable;

    const STATUS_PENDING = 'pending';

    const STATUS_ACCEPTED = 'accepted';

    const STATUS_NEW = 'new';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'description',
        'status',
    ];
    public static array $filterColumns = [
        'name',
        'mobile',
        'ticket',
    ];

    public static function getFilterInputs(): array
    {
        $filters = Arr::only(config('core.filters'), self::$filterColumns);

        return $filters;
    }
    public static function getAvailableStatues(): array
    {
        return [
            static::STATUS_PENDING,
            static::STATUS_ACCEPTED,
            static::STATUS_NEW
        ];
    }
}
