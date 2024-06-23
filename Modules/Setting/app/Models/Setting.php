<?php

namespace Modules\Setting\Models;

use Illuminate\Http\UploadedFile;
use Modules\Core\Models\BaseModel;
use Modules\Core\Traits\HasCache;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Setting extends BaseModel implements HasMedia
{
    use  InteractsWithMedia, HasCache;

    const ACCEPTED_FILE_MIMES = 'jpg,jpeg,png,webp|mp4';

    const GROUP_GENERAL = 'general';
    const GROUP_SOCIAL = 'social';
    const GROUP_ABOUT = 'about';
    const GROUP_CONTACT = 'contact';
    const GROUP_HOME = 'home';
    const GROUP_FOOTER = 'footer';

    const TYPE_TEXT = 'text';
    const TYPE_IMAGE = 'image';
    // const TYPE_VIDEO = 'video';

    const TYPE_NUMBER = 'number';
    const TYPE_TEXTAREA = 'textarea';

    protected $fillable = [
        'name',
        'group',
        'label',
        'type',
        'value',
    ];
    public static function getAllGroups(): array
    {
        return [
            static::GROUP_GENERAL => [
                'title' => 'تنظیمات عمومی',
                'summary' => 'تنظیمات عمومی سایت این بخش قرار می گیرد.',
                'bg' => 'primary',
                'icon' => 'info'
            ],
            static::GROUP_SOCIAL => [
                'title' => 'شبکه های اجتماعی',
                'summary' => 'شبکه های اجتماعی در این بخش قرار می گیرد.',
                'bg' => 'pink',
                'icon' => 'instagram'
            ],
            static::GROUP_ABOUT => [
                'title' => 'گروه درباره ما',
                'summary' => 'تنظیمات  درباره ما سایت در این بخش قرار می گیرد.',
                'bg' => 'success',
                'icon' => 'paperclip'
            ],
            static::GROUP_CONTACT => [
                'title' => 'گروه تماس با ما',
                'summary' => 'تنظیمات تماس با ما در این بخش قرار می گیرد.',
                'bg' => 'warning',
                'icon' => 'phone'
            ],
            // static::GROUP_HOME => [
            //     'title' => 'گروه صفحه اصلی',
            //     'summary' => 'تنظیمات صفحه اصلی در این بخش قرار می گیرد.',
            //     'bg' => 'danger',
            //     'icon' => 'home'
            // ],
            // static::GROUP_FOOTER => [
            //     'title' => 'گروه فوتر',
            //     'summary' => 'تنظیمات فوتر سایت در این بخش قرار می گیرد.',
            //     'bg' => 'warning',
            //     'icon' => 'list'
            // ],
        ];
    }

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
        $this->addMediaCollection('setting_files')->singleFile();
    }

    public function getFileAttribute(): ?array
    {
        $media = $this->getFirstMedia('setting_files');

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
        return $this->addMedia($file)->toMediaCollection('setting_files');
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
