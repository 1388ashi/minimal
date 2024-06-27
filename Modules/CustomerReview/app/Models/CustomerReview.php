<?php

namespace Modules\CustomerReview\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerReview extends Model implements HasMedia
{
    use HasFactory, LogsActivity, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'city',
        'description',
    ];

    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" نظر مشتریان با شناسه {$modelid} توسط کاربر باشناسه {$userid}";

        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
    //media
    protected $with = ['media'];
    protected $hidden = ['media'];
    protected $appends = ['image','video'];

    public function registerMediaCollections(): void {
        $this->addMediaCollection('customerReviews_images')->singleFile();
        $this->addMediaCollection('customerReviews_videos')->singleFile();
    }
    protected function image() : Attribute
    {
        $media = $this->getFirstMedia('customerReviews_images');

        return Attribute::make(
            get: fn () => [
                'id' => $media?->id,
                'url' => $media?->getFullUrl(),
                'name' => $media?->file_name
            ],
        );
    }
    protected function video(): Attribute
    {
        $media = $this->getFirstMedia('customerReviews_videos');

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
        return $this->addMedia($file)->toMediaCollection('customerReviews_images');
    }
    public function addVideo(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('customerReviews_videos');
    }
    public function uploadFiles(Request $request): void{

        $this->uploadImage($request);
        $this->uploadVideo($request);
    }
    public function uploadImage(Request $request): void
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $this->addImage($request->file('image'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('CustomerReview upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('CustomerReview upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
    public function uploadVideo(Request $request): void
    {
        try {
            if ($request->hasFile('video') && $request->file('video')->isValid()) {
                $this->addVideo($request->file('video'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('CustomerReview upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('CustomerReview upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
}
