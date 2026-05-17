<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\LearnColumn;
use Illuminate\Http\RedirectResponse;

class LikeController extends Controller
{
    public function togglePost(Post $post): RedirectResponse
    {
        $existing = $post->likes()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $post->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }

    public function toggleLearnColumn(LearnColumn $learnColumn): RedirectResponse
    {
        $existing = $learnColumn->likes()
            ->where('user_id', auth()->id())
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            $learnColumn->likes()->create([
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }
}