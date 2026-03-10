<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExhibitionCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function exhibitions(): HasMany
    {
        return $this->hasMany(Exhibition::class, 'category_id');
    }
}