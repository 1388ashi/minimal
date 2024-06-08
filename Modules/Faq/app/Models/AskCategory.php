<?php

// namespace Modules\Faq\Models;

// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Traits\LogsActivity;

// class AskCategory extends Model
// {
//     use HasFactory,LogsActivity;

//     /**
//      * The attributes that are mass assignable.
//      */
//     protected $fillable = [
//         'title',
//         'status',
//     ];
//     public function asks(): BelongsToMany 
//     {
//         return $this->belongsToMany(Ask::class);
//     }

//     public function getActivitylogOptions() : LogOptions
//     {
//         $modelid = $this->attributes['id'];
//         $userid = auth()->user()->id;
//         $description =" دسته بندی سوالات متداول با شناسه {$modelid} توسط کاربر باشناسه {$userid}";
        
//         return LogOptions::defaults()
//         ->logOnly($this->fillable)
//         ->setDescriptionForEvent(fn(string $eventName) => $description . __('custom.'.$eventName));
//     }
// }
