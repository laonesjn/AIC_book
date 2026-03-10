<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function publications()
    {
        return $this->hasMany(Publication::class);
    }

    /**
     * Get the count of subcategories
     */
    public function getSubcategoryCountAttribute()
    {
        return $this->children()->count();
    }

    /**
     * Scope to get only main categories (no parent)
     */
    public function scopeMainCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to get only subcategories
     */
    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }
}
