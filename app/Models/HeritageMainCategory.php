<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeritageMainCategory extends Model
{
    use HasFactory;

    protected $table = 'heritage_main_categories';

    protected $fillable = [
        'name',
        'description',
        'image',
        'view_count',
        'master_main_category_id',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the master category that this main category belongs to
     */
    public function masterCategory()
    {
        return $this->belongsTo(HeritageMasterMainCategory::class, 'master_main_category_id');
    }

    /**
     * Get the sub categories for the main category
     */
    public function subCategories()
    {
        return $this->hasMany(HeritageSubCategory::class, 'main_category_id');
    }

    /**
     * Get the collections for the main category
     */
    public function collections()
    {
        return $this->hasMany(HeritageCollection::class, 'main_category_id');
    }

    /**
     * Get sub categories count
     */
    public function getSubCategoriesCountAttribute()
    {
        return $this->subCategories()->count();
    }

    /**
     * Increment view count
     */
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    /**
     * Search scope
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%")
                     ->orWhere('description', 'like', "%{$search}%");
    }

    /**
     * Ordered scope
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }
}
