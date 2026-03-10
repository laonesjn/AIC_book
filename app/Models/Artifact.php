<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Artifact extends Model
{
    use HasFactory;
    // SoftDeletes removed

    protected $fillable = [
        'exhibition_id',
        'name',
        'description',
        'image_path',
        'file_location', // Physical location of the artifact e.g. "Room A, Display Case 3"
    ];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}