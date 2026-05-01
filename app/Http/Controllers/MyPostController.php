<?php

namespace App\Http\Controllers;

use App\Enums\PostStatus;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyPostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = Post::query()
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return view('my-posts.index', compact('posts'));
    }

    public function edit(Request $request, Post $post): View
    {
        $this->authorize('update', $post);

        $tags = Tag::query()->orderBy('tag_kind')->orderBy('sort_order')->get();

        return view('my-posts.edit', [
            'post' => $post,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:10', 'max:20000'],
            'tag_ids' => ['nullable', 'array'],
            'tag_ids.*' => ['integer', 'exists:tags,id'],
        ]);

        $post->update([
            'body_original' => $validated['body'],
            'status' => PostStatus::Pending,
            'rejection_reason' => null,
        ]);

        $post->tags()->sync($validated['tag_ids'] ?? []);

        return redirect()->route('me.posts')->with('status', 'updated');
    }
}
