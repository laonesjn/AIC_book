<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterMainCategory extends Model
{
    use HasFactory;

    protected $table = 'master_main_categories';

    protected $fillable = [
        'name',
        'view_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationship to main categories (optional if you use CollectionMainCategory)
    public function mainCategories()
    {
        return $this->hasMany(CollectionMainCategory::class, 'master_main_category_id');
    }

    // Relationship to collections
    public function collections()
    {
        return $this->hasMany(\App\Models\Collection::class, 'master_main_category_id');
    }

    // Get the count of main categories
    public function getMainCategoriesCountAttribute()
    {
        return $this->mainCategories()->count();
    }

    // Increment view count
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }

    // Search scope
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    // Ordered scope
    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }
}