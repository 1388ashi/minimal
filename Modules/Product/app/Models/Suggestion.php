<?php

namespace Modules\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Product\Database\Factories\SuggestFactory;

class Suggestion extends Model
{
    use HasFactory;

    protected $table = 'suggestions';
    protected $fillable = ['id','product_id'];

    public function product(): BelongsTo 
    {
        return $this->belongsTo(Product::class);
    }
}
