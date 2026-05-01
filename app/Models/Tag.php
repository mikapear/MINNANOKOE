<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'tag_kind',
        'tag_group_id',
        'sort_order',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(TagGroup::class, 'tag_group_id');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag');
    }

    public function learnColumns(): BelongsToMany
    {
        return $this->belongsToMany(LearnColumn::class, 'learn_column_tag', 'tag_id', 'learn_column_id');
    }
}
