<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_active',
        'starts_at',
        'ends_at',
        'sort_order',
    ];
}