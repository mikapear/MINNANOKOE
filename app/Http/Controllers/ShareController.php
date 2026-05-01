<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShareController extends Controller
{
    public function create(): View
    {
        $tags = Tag::query()->orderBy('tag_kind')->orderBy('sort_order')->get();

        return view('share.create', compact('tags'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:20000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ]);

        $post = Post::query()->create([
            'user_id' => $request->user()->id,
            'body_original' => $validated['body'],
            'status' => PostStatus::Pending,
        ]);

        if (! empty($validated['tag_ids'])) {
            $post->tags()->sync($validated['tag_ids']);
        }

        return redirect()->route('me.posts')->with('status', 'posted');
    }
}
