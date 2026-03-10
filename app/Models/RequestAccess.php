<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'publication_id', 'name', 'email', 'phone', 'why', 'status','pay_status'
    ];
    
    public function publication()
{
    return $this->belongsTo(Publication::class, 'publication_id');
}

}
