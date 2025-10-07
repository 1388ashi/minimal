<?php

namespace Modules\About\Models;

use Illuminate\Http\UploadedFile;
use Modules\Core\Models\BaseModel;
use Modules\Core\Traits\HasCache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AboutUs extends BaseModel implements HasMedia
{
    use InteractsWithMedia, HasCache;

    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    // const TYPE_VIDEO = 'video';

    const TYPE_NUMBER = 'number';
    const TYPE_TEXTAREA = 'textarea';
     protected $fillable = [
        'name',
        'label',
        'type',
        'text',
    ];

     public static function getAllTypes(): array
    {
        return [
            static::TYPE_TEXT => 'متن کوتاه',
            static::TYPE_TEXTAREA => 'متن بلند',
            static::TYPE_NUMBER => 'عددی',
            static::TYPE_IMAGE => 'فایل عکس',
            // static::TYPE_VIDEO => 'فایل ویدئو',
        ];
    }

     //start media
    protected $with = ['media'];

    protected $hidden = ['media', 'file'];

    protected $appends = ['file'];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('aboutus_files')->singleFile();
    }

    public function getFileAttribute(): ?array
    {
        $media = $this->getFirstMedia('aboutus_files');

        return [
            'id' => $media?->id,
            'url' => $media?->getFullUrl(),
            'name' => $media?->file_name
        ];
    }


    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     */
    public function addFile(UploadedFile $file): \Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        return $this->addMedia($file)->toMediaCollection('aboutus_files');
    }

    /**
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
    public function uploadFile(UploadedFile $file): void
    {
        $this->addFile($file);
    }

}
