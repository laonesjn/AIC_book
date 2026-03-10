<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeritageMasterMainCategory extends Model
{
    use HasFactory;

    protected $table = 'heritage_master_main_categories';

    protected $fillable = [
        'name',
        'view_count',
    ];

    protected $casts = [
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function collections()
    {
        return $this->hasMany(HeritageCollection::class, 'master_main_category_id');
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', "%{$search}%");
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name', 'asc');
    }
}