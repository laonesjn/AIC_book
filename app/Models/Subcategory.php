<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subcategory extends Model
{
    protected $table = 'subcategories';

    protected $fillable = ['main_category_id', 'name'];

    public function mainCategory(): BelongsTo
    {
        return $this->belongsTo(MainCategory::class);
    }

    public function publications(): HasMany
    {
        return $this->hasMany(Publication::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }
}