<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeritageCollection extends Model
{
    use HasFactory, \App\Traits\Auditable;

    protected $table = 'heritage_collections';

    protected $fillable = [
        'master_main_category_id',
        'title',
        'description',
        'title_image',
        'images',
        'access_type',
        'pdf',
        'view_count',
    ];

    protected $casts = [
        'images'     => 'array',
        'view_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────────────────────────────

    public function masterMainCategory()
    {
        return $this->belongsTo(HeritageMasterMainCategory::class, 'master_main_category_id');
    }

    public function oneDriveLinks()
    {
        return $this->morphMany(OneDriveLink::class, 'linkable');
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    public function isPublic(): bool
    {
        return $this->access_type === 'Public';
    }

    public function isPrivate(): bool
    {
        return $this->access_type === 'Private';
    }

    public function incrementViewCount(): void
    {
        $this->increment('view_count');
    }

    public function getImagesArray(): array
    {
        return $this->images ?? [];
    }

    // ── Scopes ─────────────────────────────────────────────────────────────────

    public function scopePublic($query)
    {
        return $query->where('access_type', 'Public');
    }

    public function scopePrivate($query)
    {
        return $query->where('access_type', 'Private');
    }

    public function scopeForMaster($query, int $masterMainCategoryId)
    {
        return $query->where('master_main_category_id', $masterMainCategoryId);
    }
}