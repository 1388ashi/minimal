<?php

namespace Modules\Product\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Comment\Models\Comment;
use Modules\PurchaseAdvisor\Models\PurchaseAdvisor;
use Modules\Specification\Models\Specification;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\LogOptions;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model implements Viewable,HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity,HasSlug, InteractsWithViews;
    protected $fillable = [
        'title',
        'slug',
        'description',
        'price',
        'discount',
        'status',
        'created_at',
        'updated_at',
    ];

    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" محصول با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
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
    public function totalPriceWithDiscount(): int
	{
		$price = $this->attributes['price'];
		$discount = $this->attributes['discount'];

        return $price - $discount;
	}
    public static function getTopDiscountedProducts()
    {
        $topDiscountedProducts = Product::select('id', 'title', 'price','discount','slug')->where('status',1)->orderByDesc('discount')->take(20)->get();

        return $topDiscountedProducts;
    }
    public static function getTopPriceProducts()
    {
        $topPriceProducts = Product::select('id', 'title', 'price','discount','slug')->where('status',1)->orderByDesc('price')->take(20)->get();

        return $topPriceProducts;
    }
    public static function getTopCheapProducts()
    {
        $topCheapProducts =  Product::select('id', 'title', 'price','discount','slug')->where('status',1)->orderBy('price', 'ASC')->take(20)->get();

        return $topCheapProducts;
    }
    /**
     * The attributes that are mass assignable.
     */
    
    //start media-library
    protected $with = ['media'];

    protected $hidden = ['media'];
    
        protected $appends = ['image', 'galleries','video'];
        
        public function registerMediaCollections() : void
        {
            $this->addMediaCollection('product_images')->singleFile();
            $this->addMediaCollection('product_videos')->singleFile();
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
        protected function video(): Attribute
        {
            $media = $this->getFirstMedia('product_videos');
    
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
    
        public function addVideo(UploadedFile $file): bool|\Spatie\MediaLibrary\MediaCollections\Models\Media
        {
            return $this->addMedia($file)->toMediaCollection('product_videos');
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
            $this->uploadVideo($request);
            $this->uploadGalleries($request);
        }
        public function uploadImage(Request $request): void
        {
            try {
                if ($request->hasFile('image') && $request->file('image')->isValid()) {
                    $this->addImage($request->file('image'));
                }
            } catch (FileDoesNotExist $e) {
                Log::error('Product upload file (FileDoesNotExist): ' . $e->getMessage());
            }catch (FileIsTooBig $e) {
                Log::error('Product upload file (FileIsTooBig): ' . $e->getMessage());
            }
        }
    
        public function uploadVideo(Request $request): void
        {
            try {
                if ($request->hasFile('video') && $request->file('video')->isValid()) {
                    $this->addVideo($request->file('video'));
                }
            } catch (FileDoesNotExist $e) {
                Log::error('Product upload file (FileDoesNotExist): ' . $e->getMessage());
            }catch (FileIsTooBig $e) {
                Log::error('Product upload file (FileIsTooBig): ' . $e->getMessage());
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
                Log::error('آپلود فایل برای دسته بندی (فایل وجود ندارد) : ' . $e->getMessage());
            } catch (FileIsTooBig $e) {
                Log::error('آپلود فایل برای دسته بندی (حجم فایل زیاد است) : ' . $e->getMessage());
            }
        }
        public function specifications(): BelongsToMany 
        {
            return $this->belongsToMany(Specification::class)->withPivot('value');
        }
        public function categories(): BelongsToMany 
        {
            return $this->belongsToMany(Category::class);
        }
        public function advisors(): HasMany 
        {
            return $this->hasMany(PurchaseAdvisor::class);
        }
        public function comments(): HasMany 
        {
            return $this->hasMany(Comment::class);
        }
        public function colors(): BelongsToMany 
        {
            return $this->belongsToMany(Color::class);
        }
        public function suggest(): HasOne 
        {
            return $this->hasOne(Suggest::class);
        }
}
