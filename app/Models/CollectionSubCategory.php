<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionSubCategory extends Model
{

    protected $table = 'collectionsub_categories';

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
        return $this->belongsTo(CollectionMainCategory::class, 'main_category_id');
    }

    /**
     * Get the collections for the sub category
     */
    public function collections()
    {
        return $this->hasMany(Collection::class, 'sub_category_id');
    }

    /**
     * Get collections count
     */
    public function getCollectionsCountAttribute()
    {
        return $this->collections()->count();
    }
}