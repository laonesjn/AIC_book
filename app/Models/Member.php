<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'full_name',
        'nic',
        'phone',
        'email',
        'address',
        'purpose',
        'photo_path',
        'verification_document_path',
        'status',
    ];
}
