<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeritageSubCategory extends Model
{
     use HasFactory;

    protected $table = 'heritage_sub_categories';

    protected $fillable = [
        'main_category_id',
        'name',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the main category for the sub category
     */
    public function mainCategory()
    {
        return $this->belongsTo(HeritageMainCategory::class, 'main_category_id');
    }

    /**
     * Get the collections for the sub category
     */
    public function collections()
    {
        return $this->hasMany(HeritageCollection::class, 'sub_category_id');
    }

    /**
     * Get collections count
     */
    public function getCollectionsCountAttribute()
    {
        return $this->collections()->count();
    }
}
