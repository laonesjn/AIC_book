<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    protected $table = 'committee_members';

    protected $fillable = [
        'full_name',
        'purpose',
        'email',
        'phone',
        'address',
        'nic',
        'photo_path',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
