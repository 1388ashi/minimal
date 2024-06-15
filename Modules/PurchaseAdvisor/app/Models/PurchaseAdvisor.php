<?php

namespace Modules\PurchaseAdvisor\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Modules\Core\Traits\Filterable;
use Illuminate\Support\Facades\Cache;
use Modules\Product\Models\Product;

class PurchaseAdvisor extends Model
{
    use HasFactory, Filterable;
    const STATUS_CALLED = 'called';

    const STATUS_NOTCALLED = 'notcalled';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'mobile',
        'product_id',
        'status',
    ];
    public static array $filterColumns = [
        'name',
        'purchase',
        'product_id',
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
        public static function getPurchaseStatues(): array 
        {
            return [
                static::STATUS_CALLED,
                static::STATUS_NOTCALLED
            ];
        }
        public function product(): BelongsTo 
        {
            return $this->belongsTo(Product::class);
        }
}
