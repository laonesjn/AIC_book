<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MainCategory extends Model
{
    protected $table = 'main_categories';

    protected $fillable = ['name'];

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
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