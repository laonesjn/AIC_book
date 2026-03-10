<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\Auditable;

class Publication extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'title',
        'title_image',
        'content',
        'main_category_id',
        'subcategory_id',
        'price',
        'visibleType',
        'pdf',
    ];

    protected $casts = [
        'price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getPriceLabelAttribute(): string
    {
        return $this->price == 0 ? 'Free' : '$' . number_format($this->price, 2);
    }

    public function isPublic(): bool
    {
        return $this->visibleType === 'public';
    }

    public function scopeByMainCategory($query, $mainCategoryId)
    {
        return $query->where('main_category_id', $mainCategoryId);
    }

    public function scopeBySubcategory($query, $subcategoryId)
    {
        return $query->where('subcategory_id', $subcategoryId);
    }

    public function scopeVisible($query)
    {
        return $query->where('visibleType', 'public');
    }
}