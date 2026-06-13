<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

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

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}