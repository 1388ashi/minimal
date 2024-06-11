<?php

namespace Modules\Ticket\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Filterable;
use Illuminate\Support\Facades\Cache;

class Ticket extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'description',
    ];
    public static array $filterColumns = [
        'name',
        'mobile',
    ];

    public static function getFilterInputs(): array
    {
        $filters = Arr::only(config('core.filters'), self::$filterColumns);

        return $filters;
    }
}
