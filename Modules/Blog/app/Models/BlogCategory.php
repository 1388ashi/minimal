<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogCategory extends Model
{
    use HasFactory,LogsActivity, HasSlug;
    protected $fillable = [
        'title',
        'slug',
        'status',
    ];
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'category_id');
    }
    public function isDeletable(): bool
    {
        return $this->posts->isEmpty();
    }
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" دسته بندی با شناسه {$modelid} توسط کاربر باشناسه {$userid}";

        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->usingLanguage('')
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(191)
            ->doNotGenerateSlugsOnUpdate();
    }
    public static function booted()
    {
        static::saved(function(){
            Cache::forget('all_blog_categories');
        });
        static::deleted(function(){
            Cache::forget('all_blog_categories');
        });
    }
}
