<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Modules\Brand\Models\Brand;
use Modules\Core\Models\BaseModel;
use Modules\Specification\Models\Specification;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;

class Category extends BaseModel implements HasMedia
{
    use HasFactory,LogsActivity, InteractsWithMedia;

    protected $fillable = [
        'title',
        'parent_id',
        'featured',
        'status',
    ];/**\
     */
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" دسته بندی با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
    public function isDeletable(): bool
    {
        return $this->products->isEmpty();
    }
    public function products(): BelongsToMany 
    {
        return $this->belongsToMany(Product::class);
    }
    public function brands(): BelongsToMany 
    {
        return $this->belongsToMany(Brand::class);
    }
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class,'parent_id');
        
    }
    public function children(): HasMany 
    {
        return $this->hasMany(Category::class,'parent_id');
    }
    public function recursiveChildren(): HasMany 
    {
        return $this->children()->with('children');
    }
    public function specifications() : BelongsToMany{
		return $this->belongsToMany(Specification::class);
    }
    //mediaLibrary
    protected $with = ['media'];
    protected $hidden = ['media'];
    protected $appends = ['image','dark_image'];
    
    public function registerMediaCollections(): void {
        $this->addMediaCollection('category_images')->singleFile();
        $this->addMediaCollection('category_dark_image')->singleFile();
    }
    
    protected function darkImage() : Attribute 
    {
        $media = $this->getFirstMedia('category_dark_image');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    protected function image() : Attribute 
    {
        $media = $this->getFirstMedia('category_images');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    public function addImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('category_images');
    }
    public function addDarkImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('category_dark_image');
    }
    public function uploadFiles(Request $request): void
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $this->addImage($request->file('image'));
            }
            if ($request->hasFile('dark_image') && $request->file('dark_image')->isValid()) {
                $this->addDarkImage($request->file('dark_image'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('Category upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('Category upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }

}
