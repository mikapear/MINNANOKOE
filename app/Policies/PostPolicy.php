<?php

namespace App\Policies;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function update(User $user, Post $post): bool
    {
        if ($user->id !== $post->user_id) {
            return false;
        }

        return in_array($post->status, [
            PostStatus::Pending,
            PostStatus::Rejected,
            PostStatus::Draft,
        ], true);
    }

    public function view(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}
