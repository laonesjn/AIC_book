<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OneDriveLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'linkable_id',
        'linkable_type',
        'url',
        'title',
    ];

    public function linkable()
    {
        return $this->morphTo();
    }
}
