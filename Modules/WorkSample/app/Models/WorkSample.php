<?php

namespace Modules\WorkSample\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Models\BaseModel;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

class WorkSample extends BaseModel implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title'
    ];
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" نمونه کار با شناسه {$modelid} توسط کاربر باشناسه {$userid}";

        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
    protected $with = ['media'];

    protected $hidden = ['media'];

    protected $appends = ['image', 'galleries'];
    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('product_images')->singleFile();
        $this->addMediaCollection('product_galleries');
    }
    protected function image(): Attribute
    {
        $media = $this->getFirstMedia('product_images');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    protected function galleries(): Attribute
    {
        $media = $this->getMedia('product_galleries');

        $galleries = [];
        if ($media->count()) {
            foreach ($media as $mediaItem) {
                $galleries[] = [
                    'id' => $mediaItem?->id,
                    'url' => $mediaItem?->getFullUrl(),
                    'name' => $mediaItem?->file_name
                ];
            }
        }

        return Attribute::make(
            get: fn () => $galleries,
        );
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function addImage(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('product_images');
    }

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function addGallery(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('product_galleries');
    }
    public function uploadFiles(Request $request): void{

        $this->uploadImage($request);
        $this->uploadGalleries($request);
    }
    public function uploadImage(Request $request): void
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $this->addImage($request->file('image'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('WorkSample upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('WorkSample upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }

    public function uploadVideo(Request $request): void
    {
        try {
            if ($request->hasFile('video') && $request->file('video')->isValid()) {
                $this->addVideo($request->file('video'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('WorkSample upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('WorkSample upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
    protected function uploadGalleries(Request $request): void
    {
        try {
            if ($request->hasFile('galleries')) {
                foreach ($request->file('galleries') as $image) {
                    if ($image->isValid()) {
                        $this->addGallery($image);
                    }
                }
            }

            if ($request->method() == 'PATCH' && $request->filled('deleted_image_ids')) {
                $this->deleteImages($request->input('deleted_image_ids'));
            }

        } catch (FileDoesNotExist $e) {
            Log::error('WorkSample upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('WorkSample upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
}
