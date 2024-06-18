<?php

namespace Modules\JobOffer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class JobOffer extends Model
{
    use HasFactory, LogsActivity;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'job_offers';
    protected $fillable = [
        'title',
        'times',
        'type',
        'description',
        'status',
    ];
    public function getActivitylogOptions() : LogOptions
    {
        $modelid = $this->attributes['id'];
        $userid = auth()->user()->id;
        $description =" فرصت شغلی با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
        return LogOptions::defaults()
        ->logOnly($this->fillable)
        ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
    }
    public function isDeletable(): bool
    {
        return $this->resumes->isEmpty();
    }
    public function resumes(): BelongsToMany 
    {
        return $this->belongsToMany(Resumes::class);
    }
}
