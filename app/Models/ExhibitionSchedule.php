<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExhibitionSchedule extends Model
{
    use HasFactory;

    protected $table    = 'exhibition_schedules';
    protected $fillable = ['exhibition_id', 'day', 'time_from', 'time_to'];

    public function exhibition(): BelongsTo
    {
        return $this->belongsTo(Exhibition::class);
    }
}