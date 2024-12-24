<?php

namespace Modules\Brand\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Modules\Product\Models\Product;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class Brand extends Model implements HasMedia
{
    use HasFactory, LogsActivity,InteractsWithMedia;

    protected $fillable = [
        'title','status','description'
    ];
    protected $with = ['media'];
    protected $hidden = ['media'];
    protected $appends = ['image','background'];
    
    public function registerMediaCollections(): void {
        $this->addMediaCollection('brand_images')->singleFile();
        $this->addMediaCollection('brand_background')->singleFile();
    }
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
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
    protected function image() : Attribute 
    {
        $media = $this->getFirstMedia('brand_images');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    protected function background() : Attribute 
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
    public function addImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('brand_images');
    }
    public function addBackground(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('brand_background');
    }
    public function uploadFiles(Request $request): void
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $this->addImage($request->file('image'));
            }
            if ($request->hasFile('background_image') && $request->file('background_image')->isValid()) {
                $this->addBackground($request->file('background_image'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('Brand upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('Brand upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }

}
