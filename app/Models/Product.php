<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [ 'title', 'slug', 'image', 'description', 'price', 'compare_price', 'sku', '	track_qty', 'quantity', 'sub_category_id', 'created_by', 'updated_by', 'deleted_by' ];

    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }
}
