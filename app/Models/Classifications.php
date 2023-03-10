<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classifications extends Model
{
    use HasFactory;
    // protected $table = 'classification';
    protected $fillable = [
        'code',
        'type',
        'description',
    ];
}
