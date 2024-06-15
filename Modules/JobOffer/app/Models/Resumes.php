<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Modules\Core\Traits\Filterable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class Resumes extends Model implements HasMedia
{
    use HasFactory, Filterable, InteractsWithMedia;
    
    const STATUS_NEW = 'new';
    const STATUS_PENDING = 'pending';
    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REJECTED = 'rejected';
    const STATUS_CONFIRM_INTERVIEW = 'confirm_interview';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'mobile',
        'status',
        'description',
        'job_id',
    ];

    public static array $filterColumns = [
        'name',
        'resumes',
        'job_id',
    ];

    public static function getFilterInputs(): array
    {
        $filters = Arr::only(config('core.filters'), self::$filterColumns);
        $filters['job_id']['options'] = Cache::rememberForever('all_job_offers', function () {
            return JobOffer::query()
                ->latest('title')
                ->pluck('title', 'id');
        });

        return $filters;
    }
    public static function getResumesStatues(): array 
    {
        return [
            static::STATUS_NEW,
            static::STATUS_CONFIRM_INTERVIEW,
            static::STATUS_PENDING,
            static::STATUS_ACCEPTED,
            static::STATUS_REJECTED
        ];
    }
    public function job(): BelongsTo 
    {
        return $this->belongsTo(JobOffer::class);
    }

     //mediaLibrary
    protected $with = ['media'];
    protected $hidden = ['media'];
    protected $appends = ['file'];
    
    public function registerMediaCollections(): void {
        $this->addMediaCollection('resumes_files')->singleFile();
    }
    
    protected function image() : Attribute 
    {
        $media = $this->getFirstMedia('resumes_files');

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
        return $this->addMedia($file)->toMediaCollection('resumes_files');
    }
    public function uploadFiles(Request $request): void
    {
        try {
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $this->addImage($request->file('file'));
            }
        } catch (FileDoesNotExist $e) {
            Log::error('Resumes upload file (FileDoesNotExist): ' . $e->getMessage());
        }catch (FileIsTooBig $e) {
            Log::error('Resumes upload file (FileIsTooBig): ' . $e->getMessage());
        }
    }
}
