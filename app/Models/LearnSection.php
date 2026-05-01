<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LearnSection extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'sort_order',
    ];

    public function columns(): HasMany
    {
        return $this->hasMany(LearnColumn::class)->orderBy('sort_order');
    }
}
