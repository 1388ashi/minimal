<?php

namespace Modules\Blog\Models;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;
use Modules\Core\Models\BaseModel;
use Modules\Core\Traits\Filterable;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class Post extends BaseModel implements HasMedia, Viewable
{
    use HasFactory, InteractsWithMedia,LogsActivity, Filterable, InteractsWithViews;
    protected $fillable = [
        'title',
        'category_id',
        'summary',
        'body',
        'type',
        'published_at',
        'writer',
        'slug',
        'read',
        'featured',
        'status',
    ];
    public static array $filterColumns = [
        'title',
        'writer',
        'category_id',
        'status'
    ];

    public static function getFilterInputs(): array
    {
        $filters = Arr::only(config('core.filters'), self::$filterColumns);
        $filters['category_id']['options'] = Cache::rememberForever('all_blog_categories', function () {
            return BlogCategory::query()
            ->latest('title')
            ->where('type','article')
            ->pluck('title', 'id');
        });
        return $filters;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" پست با شناسه {$modelid} توسط کاربر باشناسه {$userid}";

        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
        //start media-library
        protected $with = ['media'];

        protected $hidden = ['media'];

        protected $appends = ['image'];

        public function registerMediaCollections() : void
        {
            $this->addMediaCollection('blog_images')->singleFile();
        }

        protected function image(): Attribute
        {
            $media = $this->getFirstMedia('blog_images');

            return Attribute::make(
                get: fn () => [
                    'id' => $media?->id,
                    'url' => $media?->getFullUrl(),
                    'name' => $media?->file_name
                ],
            );
        }
        /**
         * @throws FileDoesNotExist
         * @throws FileIsTooBig
         */
        public function addImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
        {
            return $this->addMedia($file)->toMediaCollection('blog_images');
        }
        /**
         * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
         * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
         */
        public function uploadFiles(Request $request): void{
            $this->uploadImage($request);
        }
        public function uploadImage(Request $request): void
        {
            try {
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $this->addImage($request->file('image'));
                }
            } catch (FileDoesNotExist $e) {
                Log::error('Blog upload file (FileDoesNotExist): ' . $e->getMessage());
            }catch (FileIsTooBig $e) {
                Log::error('Blog upload file (FileIsTooBig): ' . $e->getMessage());
            }
        }
}
