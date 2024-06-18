<?php

namespace Modules\Specification\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Specification extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'status',
        'category_id',
    ];
    public function isDeletable(): bool
    {
        return $this->products->isEmpty() || $this->categories->isEmpty() ;
    }
    public function categories() : BelongsToMany{
        return $this->belongsToMany(Category::class);
    }
    public function products(): BelongsToMany 
    {
        return $this->belongsToMany(Product::class)->withPivot('value');
    }
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" محصول با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
}
