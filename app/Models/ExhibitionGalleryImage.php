<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExhibitionGalleryImage extends Model
{
    use HasFactory;

    protected $table    = 'exhibition_gallery_images';
    protected $fillable = ['exhibition_id', 'image_path'];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}