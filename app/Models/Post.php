<?php

namespace App\Models;

use App\Enums\PostStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'slug',
        'body_original',
        'body_published',
        'summary',
        'status',
        'rejection_reason',
        'reviewed_by',
        'reviewed_at',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => PostStatus::class,
            'reviewed_at' => 'datetime',
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', PostStatus::Published)
            ->whereNotNull('slug')
            ->whereNotNull('body_published')
            ->whereNotNull('published_at');
    }

    public function displayBody(): string
    {
        return $this->body_published ?? '';
    }

    public static function makeUniqueSlug(string $seed, ?int $exceptPostId = null): string
    {
        $base = Str::slug(Str::limit($seed, 60, ''));
        if ($base === '') {
            $base = 'story';
        }

        $slug = $base;
        $n = 2;
        while (static::query()
            ->when($exceptPostId, fn ($q) => $q->where('id', '!=', $exceptPostId))
            ->where('slug', $slug)
            ->exists()) {
            $slug = $base.'-'.$n;
            $n++;
        }

        return $slug;
    }
}
