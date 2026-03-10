<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exhibition extends Model
{
    use HasFactory, \App\Traits\Auditable;
    // SoftDeletes removed

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'tour_link',
        'exhibition_location', // Physical location e.g. "Hall B, Floor 2"
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExhibitionCategory::class, 'category_id');
    }

    public function galleryImages(): HasMany
    {
        return $this->hasMany(ExhibitionGalleryImage::class);
    }

   
    public function artifacts(): HasMany
    {
        return $this->hasMany(Artifact::class);
    }

    public function oneDriveLinks()
    {
        return $this->morphMany(OneDriveLink::class, 'linkable');
    }

}