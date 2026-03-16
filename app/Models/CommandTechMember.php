<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandTechMember extends Model
{
    use HasFactory;

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
        'type', // 'committee' or 'technical'
    ];
}
