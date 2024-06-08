<?php

namespace Modules\Core\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;

trait BaseModelTrait
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopePaginateOrAll($query, $perPage = 15, $columns = ['*'])
    {
        $perPage = request('per_page', $perPage);

        return request('all') ? $query->get($columns) : $query->paginate($perPage, $columns);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('status', 1);
    }
}

