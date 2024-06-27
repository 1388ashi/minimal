<?php

namespace Modules\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Core\Models\BaseModel;
use Modules\Core\Traits\Filterable;
use Modules\Product\Models\Product;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class Comment extends BaseModel
{
    use HasFactory, Filterable;

    const STATUS_PENDING = 'pending';

    const STATUS_ACCEPTED = 'accepted';

    const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'product_id',
        'mobile',
        'text',
        'status',
        'description',
        'star',
    ];
    public static array $filterColumns = [
        'name', 'product_id', 'comment'
    ];

    public static function getFilterInputs(): array
    {
        $filters = Arr::only(config('core.filters'), self::$filterColumns);
        $filters['product_id']['options'] = Cache::rememberForever('all_products', function () {
            return Product::query()
                ->latest('title')
                ->pluck('title', 'id');
        });

        return $filters;
    }

    public static function getAvailableStatues(): array
    {
        return [
            static::STATUS_PENDING,
            static::STATUS_ACCEPTED,
            static::STATUS_REJECTED
        ];
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
