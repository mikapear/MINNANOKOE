<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LearnColumn extends Model
{
    protected $table = 'learn_columns';

    protected $fillable = [
        'learn_section_id',
        'slug',
        'title',
        'body',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(LearnSection::class, 'learn_section_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'learn_column_tag', 'learn_column_id', 'tag_id');
    }
}
