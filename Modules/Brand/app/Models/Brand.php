<?php

namespace Modules\Brand\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Modules\Product\Models\Category;
use Modules\Product\Models\Product;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Brand extends Model implements HasMedia, Sortable
{
    use HasFactory, LogsActivity,InteractsWithMedia, SortableTrait;

    protected $defaults = [
        'order' => 1
    ];
     public $sortable = [
      'order_column_name' => 'order',
      'sort_when_creating' => true,
    ];
    protected $fillable = [
        'title','status','description'
    ];
    protected $with = ['media'];
    protected $hidden = ['media'];
    protected $appends = ['white_image','dark_image', 'background'];

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('brand_white')->singleFile();
        $this->addMediaCollection('brand_dark')->singleFile();
        $this->addMediaCollection('brand_background')->singleFile();
    }

    protected function whiteImage(): Attribute
    {
        $media = $this->getFirstMedia('brand_white');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    protected function darkImage(): Attribute
    {
        $media = $this->getFirstMedia('brand_dark');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    protected function background(): Attribute
    {
        $media = $this->getFirstMedia('brand_background');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }

    public function addWhiteImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('brand_white');
    }
    public function addDarkImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('brand_dark');
    }
    public function addBackground(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('brand_background');
    }

    public function uploadFiles(Request $request): void{

        $this->uploadWhiteImage($request);
        $this->uploadDarkImage($request);
        $this->uploadBackground($request);
    }
    public function uploadDarkImage(Request $request): void
    {
        try {
            if ($request->hasFile('dark_image') && $request->file('dark_image')->isValid()) {
                $this->addDarkImage($request->file('dark_image'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('Product upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('Product upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
    public function uploadWhiteImage(Request $request): void
    {
        try {
            if ($request->hasFile('white_image') && $request->file('white_image')->isValid()) {
                $this->addWhiteImage($request->file('white_image'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('Product upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('Product upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
    public function uploadBackground(Request $request): void
    {
        try {
            if ($request->hasFile('background') && $request->file('background')->isValid()) {
                $this->addBackground($request->file('background'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('Product upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('Product upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    public function categories(): BelongsToMany 
    {
        return $this->belongsToMany(Category::class);
    }
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" برند با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }


}
