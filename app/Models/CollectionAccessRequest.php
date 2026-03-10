<?php
// app/Models/CollectionAccessRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionAccessRequest extends Model
{
    protected $fillable = [
        'collection_id',
        'name',
        'email',
        'phone',
        'full_phone',
        'country_name',
        'why',
        'status',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }
}